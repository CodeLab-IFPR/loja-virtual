<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ImageHelper
{
    /**
     * Redimensiona e otimiza uma imagem
     */
    public static function resizeAndOptimize(UploadedFile $file, $maxWidth = 800, $maxHeight = 600, $quality = 85)
    {
        $imagePath = $file->getRealPath();
        $imageInfo = getimagesize($imagePath);
        
        if (!$imageInfo) {
            return false;
        }
        
        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];
        $mimeType = $imageInfo['mime'];
        
        // Se a imagem já é menor que o máximo, não redimensiona
        if ($originalWidth <= $maxWidth && $originalHeight <= $maxHeight) {
            return $file;
        }
        
        // Calcula as novas dimensões mantendo a proporção
        $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
        $newWidth = intval($originalWidth * $ratio);
        $newHeight = intval($originalHeight * $ratio);
        
        // Cria a imagem fonte baseada no tipo
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($imagePath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($imagePath);
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($imagePath);
                break;
            default:
                return false;
        }
        
        if (!$sourceImage) {
            return false;
        }
        
        // Cria a nova imagem
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserva transparência para PNG
        if ($mimeType === 'image/png') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
        }
        
        // Redimensiona
        imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
        
        // Salva a imagem otimizada em um arquivo temporário
        $tempPath = tempnam(sys_get_temp_dir(), 'optimized_');
        
        switch ($mimeType) {
            case 'image/jpeg':
                imagejpeg($resizedImage, $tempPath, $quality);
                break;
            case 'image/png':
                imagepng($resizedImage, $tempPath, floor($quality / 10));
                break;
            case 'image/gif':
                imagegif($resizedImage, $tempPath);
                break;
            case 'image/webp':
                imagewebp($resizedImage, $tempPath, $quality);
                break;
        }
        
        // Limpa memória
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);
        
        // Cria um novo UploadedFile com a imagem otimizada
        $optimizedFile = new UploadedFile(
            $tempPath,
            $file->getClientOriginalName(),
            $file->getClientMimeType(),
            null,
            true // test mode
        );
        
        return $optimizedFile;
    }

    /**
     * Verifica se uma imagem existe no storage
     */
    public static function imageExists($path)
    {
        if (!$path) {
            return false;
        }
        
        return Storage::disk('public')->exists($path);
    }

    /**
     * Retorna a URL da imagem com fallback
     */
    public static function getImageUrl($path, $fallback = null)
    {
        if (!$path) {
            return $fallback ?: self::getPlaceholderUrl();
        }

        // Verifica se a imagem existe
        if (self::imageExists($path)) {
            return asset('storage/' . $path);
        }

        return $fallback ?: self::getPlaceholderUrl();
    }

    /**
     * Retorna URL de placeholder
     */
    public static function getPlaceholderUrl()
    {
        return 'data:image/svg+xml;base64,' . base64_encode('
            <svg width="300" height="300" xmlns="http://www.w3.org/2000/svg">
                <rect width="100%" height="100%" fill="#f3f4f6"/>
                <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="14" fill="#9ca3af" text-anchor="middle" dy=".3em">
                    Imagem não encontrada
                </text>
            </svg>
        ');
    }

    /**
     * Retorna a primeira imagem disponível de um produto
     */
    public static function getFirstProductImage($product)
    {
        // Verifica imagem principal
        if ($product->image && self::imageExists($product->image)) {
            return self::getImageUrl($product->image);
        }

        // Verifica imagens adicionais
        $images = $product->images;
        
        // Se for string (JSON), decodifica
        if (is_string($images)) {
            $images = json_decode($images, true) ?: [];
        }
        
        // Se não for array, retorna placeholder
        if (!is_array($images)) {
            return self::getPlaceholderUrl();
        }
        
        // Procura a primeira imagem que existe
        foreach ($images as $imagePath) {
            if (self::imageExists($imagePath)) {
                return self::getImageUrl($imagePath);
            }
        }
        
        return self::getPlaceholderUrl();
    }

    /**
     * Retorna todas as imagens válidas de um produto
     */
    public static function getAllProductImages($product)
    {
        $validImages = [];

        // Adiciona imagem principal se existir
        if ($product->image && self::imageExists($product->image)) {
            $validImages[] = [
                'url' => self::getImageUrl($product->image),
                'path' => $product->image,
                'type' => 'main',
                'label' => 'Principal'
            ];
        }

        // Adiciona imagens adicionais
        $images = $product->images;
        
        // Se for string (JSON), decodifica
        if (is_string($images)) {
            $images = json_decode($images, true) ?: [];
        }
        
        if (is_array($images)) {
            foreach ($images as $index => $imagePath) {
                if (self::imageExists($imagePath)) {
                    $validImages[] = [
                        'url' => self::getImageUrl($imagePath),
                        'path' => $imagePath,
                        'type' => 'additional',
                        'label' => 'Adicional ' . ($index + 1)
                    ];
                }
            }
        }

        return $validImages;
    }

    /**
     * Gera HTML de imagem com lazy loading
     */
    public static function generateImageHtml($src, $alt = '', $class = '', $placeholder = true)
    {
        $placeholderSrc = $placeholder ? self::getPlaceholderUrl() : '';
        
        return sprintf(
            '<img src="%s" data-src="%s" alt="%s" class="%s lazy-load" loading="lazy" onerror="this.src=\'%s\'">',
            $placeholderSrc,
            $src,
            htmlspecialchars($alt),
            htmlspecialchars($class),
            self::getPlaceholderUrl()
        );
    }
}