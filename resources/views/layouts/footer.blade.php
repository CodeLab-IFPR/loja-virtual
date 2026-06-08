<footer class="bg-white text-gray-800 font-sans">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="flex items-start">
                <a href="{{ route('home') }}" title="Página Inicial">
                    <img class="h-28 w-auto" src="{{ asset('images/icons/Logo_shalom.png') }}" alt="Logotipo Shalom Vasos Decor">
                </a>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4 uppercase">Atendimento</h3>
                <div class="space-y-2 text-sm">
                    <p>
                        <span class="font-bold">Telefone:</span> em breve
                    </p>
                    <p>
                        <span class="font-bold">Email:</span> contato@shalomvasos.com.br
                    </p>
                    <p>
                        <span class="font-bold">Horário de Atendimento:</span>
                        <br>das 08:00 às 18:00 (segunda à sexta)
                    </p>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4 uppercase">Institucional</h3>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="#" class="text-gray-800 hover:text-gray-600 transition">Quem Somos</a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" class="text-gray-800 hover:text-gray-600 transition">Minha Conta</a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-800 hover:text-gray-600 transition">Seja nosso Parceiro</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="border-t border-gray-200 mt-8 pt-8 text-center">
            <p class="text-sm text-gray-500">
                Shalon Vasos© - CNPJ: 09.296.714/0001-63. Todos os Direitos Reservados.
            </p>
        </div>
    </div>
</footer>
