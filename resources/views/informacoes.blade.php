@extends('layouts.app')

@section('title', 'Informações - Ellon Sports')

@section('meta-tags')
    <meta name="description" content="Conheça mais sobre a Ellon Sports, formas de pagamento e informações de contato.">
    <meta name="keywords" content="sobre nós, formas de pagamento, atendimento, contato, Ellon Sports">
    <meta property="og:title" content="Informações - Ellon Sports">
    <meta property="og:description" content="Conheça mais sobre a Ellon Sports e nossos serviços.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/informacoes') }}">
@endsection

@section('content')
<div class="informacoes-page">
    <div class="informacoes-container">
        <!-- Header da página -->
        <div class="informacoes-header">
            <div class="informacoes-header-content">
                <h1>ℹ️ Informações</h1>
                <p class="informacoes-subtitle">Tudo que você precisa saber sobre a Ellon Sports</p>
            </div>
        </div>

        <!-- Conteúdo principal -->
        <div class="informacoes-content">
            <!-- Seção 1: Sobre Nós -->
            <section id="sobre-nos" class="informacoes-section">
                <h2>📖 Sobre Nós</h2>
                <div class="informacoes-card">
                    <h3>Nossa História</h3>
                    <p>
                        A Ellon Sports é uma loja online especializada em camisetas de futebol, oferecendo produtos 
                        dos principais times brasileiros e internacionais. Nossa missão é proporcionar aos torcedores 
                        apaixonados acesso a produtos de qualidade, com excelente atendimento e entrega rápida.
                    </p>
                </div>

                <div class="informacoes-card">
                    <h3>Nossos Valores</h3>
                    <ul>
                        <li><strong>Qualidade</strong> - Produtos licenciados e de alta qualidade</li>
                        <li><strong>Confiança</strong> - Transparência em todas as transações</li>
                        <li><strong>Atendimento</strong> - Suporte dedicado ao cliente</li>
                        <li><strong>Paixão pelo Futebol</strong> - Compartilhamos a paixão pelos times</li>
                    </ul>
                </div>

                <div class="informacoes-card">
                    <h3>O Que Oferecemos</h3>
                    <ul>
                        <li><strong>Camisetas oficiais</strong> - Produtos licenciados dos times</li>
                        <li><strong>Variedade de tamanhos</strong> - Do P ao GG</li>
                        <li><strong>Times brasileiros</strong> - Principais clubes do Brasil</li>
                        <li><strong>Times internacionais</strong> - Clubes europeus e seleções</li>
                        <li><strong>Produtos exclusivos</strong> - Edições limitadas e especiais</li>
                    </ul>
                </div>

                <div class="informacoes-card">
                    <h3>Nossa Localização</h3>
                    <p>
                        Estamos localizados em <strong>Alfenas, MG - Brasil</strong>, atendendo clientes em todo o 
                        território nacional através de nossa plataforma online.
                    </p>
                </div>
            </section>

            {{-- <!-- Seção 2: Trocas e Devoluções -->
            <section id="trocas-devolucoes" class="informacoes-section">
                <h2>🔄 Trocas e Devoluções</h2>
                <div class="informacoes-card">
                    <h3>Direito de Arrependimento</h3>
                    <p>
                        Você tem <strong>7 dias corridos</strong>, contados da data de recebimento, 
                        para desistir da compra sem justificativa, conforme previsto no Código de Defesa do Consumidor.
                    </p>
                </div>

                <div class="informacoes-card">
                    <h3>Condições para Troca</h3>
                    <ul>
                        <li><strong>Produto íntegro</strong> - Sem uso ou danos</li>
                        <li><strong>Embalagem original</strong> - Etiquetas e lacres preservados</li>
                        <li><strong>Prazo de 30 dias</strong> - Para defeitos de fabricação</li>
                        <li><strong>Documentação</strong> - Nota fiscal obrigatória</li>
                    </ul>
                </div>

                <div class="informacoes-card">
                    <h3>Processo de Troca</h3>
                    <ul>
                        <li><strong>Solicitação</strong> - Via e-mail ou WhatsApp</li>
                        <li><strong>Análise</strong> - Verificação das condições do produto</li>
                        <li><strong>Envio</strong> - Custo do frete por conta do cliente</li>
                        <li><strong>Processamento</strong> - 5-10 dias úteis após recebimento</li>
                    </ul>
                </div>

                <div class="informacoes-card">
                    <h3>Reembolso</h3>
                    <p>
                        O reembolso será processado na mesma forma de pagamento utilizada na compra, 
                        em até <strong>2 faturas do cartão</strong> ou <strong>5 dias úteis</strong> para PIX/boleto.
                    </p>
                </div>

                <div class="informacoes-card">
                    <h3>Como Solicitar</h3>
                    <p>
                        Para solicitar troca ou devolução, entre em contato conosco através dos canais de atendimento, 
                        informando o número do pedido e o motivo da solicitação.
                    </p>
                </div>
            </section> --}}

            <!-- Seção 3: Formas de Pagamento -->
            <section id="formas-pagamento" class="informacoes-section">
                <h2>💳 Formas de Pagamento</h2>
                <div class="informacoes-card">
                    <h3>Cartões de Crédito</h3>
                    <p>
                        Aceitamos os principais cartões de crédito: <strong>Visa</strong>, <strong>Mastercard</strong> e <strong>Elo</strong>.
                    </p>
                    <ul>
                        <li>Parcelamento em até 12x sem juros (conforme disponibilidade)</li>
                        <li>Parcelamento com juros em até 12x</li>
                        <li>Pagamento à vista com desconto</li>
                    </ul>
                </div>

                <div class="informacoes-card">
                    <h3>Cartões de Débito</h3>
                    <p>
                        Aceitamos cartões de débito com função crédito habilitada.
                    </p>
                </div>

                <div class="informacoes-card">
                    <h3>PIX</h3>
                    <p>
                        Pagamento via <strong>PIX</strong> com aprovação instantânea e desconto especial.
                    </p>
                    <ul>
                        <li>Aprovação imediata</li>
                        <li>Desconto exclusivo</li>
                        <li>QR Code gerado automaticamente</li>
                    </ul>
                </div>

                <div class="informacoes-card">
                    <h3>Boleto Bancário</h3>
                    <p>
                        Pagamento via <strong>boleto bancário</strong> com vencimento em 3 dias úteis.
                    </p>
                    <ul>
                        <li>Vencimento em 3 dias úteis</li>
                        <li>Confirmação em até 2 dias úteis após pagamento</li>
                        <li>Desconto especial para pagamento à vista</li>
                    </ul>
                </div>

                <div class="informacoes-card">
                    <h3>Segurança</h3>
                    <p>
                        Todos os pagamentos são processados de forma segura através de gateways certificados e 
                        criptografados, garantindo a proteção dos seus dados financeiros.
                    </p>
                </div>
            </section>

            <!-- Seção 4: Atendimento / Contato -->
            <section id="atendimento-contato" class="informacoes-section">
                <h2>📞 Atendimento / Contato</h2>
                <div class="informacoes-card contact-card">
                    <h3>Entre em Contato</h3>
                    <p>
                        Nossa equipe de atendimento está pronta para ajudar você! Entre em contato através dos 
                        canais abaixo:
                    </p>
                    
                    <div class="contact-info">
                        <div class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m4 4 16 0 0 16-16 0z"/>
                                <path d="m22 6-10 7L2 6"/>
                            </svg>
                            <div>
                                <strong>E-mail:</strong><br>
                                <a href="mailto:contato@ellonsports.com">contato@ellonsports.com</a>
                            </div>
                        </div>
                        {{-- <div class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <div>
                                <strong>Telefone:</strong><br>
                                <a href="tel:+5535999999999">(35) 99999-9999</a>
                            </div>
                        </div> --}}
                        <div class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <div>
                                <strong>Endereço:</strong><br>
                                Alfenas, MG - Brasil
                            </div>
                        </div>
                        {{-- <div class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <div>
                                <strong>WhatsApp:</strong><br>
                                <a href="https://wa.me/5535999999999" target="_blank">(35) 99999-9999</a>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="informacoes-card">
                    <h3>Horário de Atendimento</h3>
                    <p>
                        <strong>Segunda a Sexta:</strong> 9h às 18h<br>
                        <strong>Sábado:</strong> 9h às 13h<br>
                        <strong>Domingo e Feriados:</strong> Fechado
                    </p>
                </div>

                <div class="informacoes-card">
                    <h3>Dúvidas Frequentes</h3>
                    <p>
                        Para dúvidas sobre produtos, pedidos, entregas ou qualquer outra questão, 
                        nossa equipe está à disposição para ajudar. Entre em contato através dos canais acima.
                    </p>
                </div>
            </section>
        </div>

        <!-- Footer da página -->
        <div class="informacoes-footer">
            <div class="informacoes-footer-content">
                <p>Estas informações estão em conformidade com o Código de Defesa do Consumidor (CDC) e demais legislações aplicáveis.</p>
                <div class="informacoes-links">
                    <a href="/politica-privacidade" class="informacoes-link">
                        Política de Privacidade
                    </a>
                    <a href="/termos-uso" class="informacoes-link">
                        Termos de Uso
                    </a>
                    <a href="/" class="back-home-btn">
                        Voltar para a página inicial
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para a página de informações */
.informacoes-page {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
    padding: 20px 0;
}

.informacoes-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header da página */
.informacoes-header {
    background: linear-gradient(135deg, #FF7C00 0%, #FFB800 100%);
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 40px;
    text-align: center;
    color: white;
    box-shadow: 0 10px 30px rgba(255, 124, 0, 0.3);
}

.informacoes-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    font-family: 'Montserrat', sans-serif;
}

.informacoes-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
}

/* Conteúdo principal */
.informacoes-content {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.informacoes-section {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
    scroll-margin-top: 100px;
}

.informacoes-section h2 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #FF7C00;
    margin-bottom: 25px;
    font-family: 'Montserrat', sans-serif;
    border-bottom: 3px solid #e2e8f0;
    padding-bottom: 10px;
}

.informacoes-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
    border-left: 4px solid #FF7C00;
}

.informacoes-card:last-child {
    margin-bottom: 0;
}

.informacoes-card h3 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 15px;
    font-family: 'Montserrat', sans-serif;
}

.informacoes-card ul {
    list-style: none;
    padding: 0;
}

.informacoes-card li {
    padding: 8px 0;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: flex-start;
}

.informacoes-card li:last-child {
    border-bottom: none;
}

.informacoes-card li::before {
    content: "✓";
    color: #FF7C00;
    font-weight: bold;
    margin-right: 10px;
    font-size: 1.1rem;
}

.informacoes-card p {
    line-height: 1.6;
    color: #475569;
    margin-bottom: 15px;
}

.informacoes-card p:last-child {
    margin-bottom: 0;
}

/* Card de contato especial */
.contact-card {
    background: linear-gradient(135deg, #fff5e6 0%, #ffe6cc 100%);
    border-left: 4px solid #FF7C00;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-top: 20px;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 15px;
    background: white;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.contact-item svg {
    color: #FF7C00;
    flex-shrink: 0;
    margin-top: 2px;
}

.contact-item a {
    color: #FF7C00;
    text-decoration: none;
}

.contact-item a:hover {
    text-decoration: underline;
}

/* Footer da página */
.informacoes-footer {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-top: 40px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
}

.informacoes-footer p {
    color: #64748b;
    margin-bottom: 20px;
    font-size: 1.1rem;
}

.informacoes-links {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.informacoes-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f1f5f9;
    color: #475569;
    padding: 12px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
}

.informacoes-link:hover {
    background: #e2e8f0;
    color: #1e293b;
    transform: translateY(-1px);
}

.back-home-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #FF7C00 0%, #FFB800 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 124, 0, 0.3);
}

.back-home-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 124, 0, 0.4);
    color: white;
}

/* Responsividade */
@media (max-width: 768px) {
    .informacoes-container {
        padding: 0 15px;
    }
    
    .informacoes-header {
        padding: 30px 20px;
        margin-bottom: 30px;
    }
    
    .informacoes-header h1 {
        font-size: 2rem;
    }
    
    .informacoes-section {
        padding: 20px;
    }
    
    .informacoes-card {
        padding: 20px;
    }
    
    .contact-info {
        gap: 10px;
    }
    
    .contact-item {
        padding: 12px;
        flex-direction: column;
        gap: 8px;
    }
    
    .informacoes-links {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .informacoes-header h1 {
        font-size: 1.8rem;
    }
    
    .informacoes-subtitle {
        font-size: 1rem;
    }
    
    .informacoes-section h2 {
        font-size: 1.5rem;
    }
    
    .informacoes-card h3 {
        font-size: 1.2rem;
    }
}
</style>
@endsection

