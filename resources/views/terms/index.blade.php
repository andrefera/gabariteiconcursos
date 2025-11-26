@extends('layouts.app')

@section('title', 'Termos de Uso - Ellon Sports')

@section('meta-tags')
    <meta name="description" content="Conheça nossos termos de uso e condições para utilização dos serviços da Ellon Sports.">
    <meta name="keywords" content="termos de uso, condições de uso, Ellon Sports, e-commerce, compras online">
    <meta property="og:title" content="Termos de Uso - Ellon Sports">
    <meta property="og:description" content="Conheça nossos termos de uso e condições para utilização dos serviços.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/termos-uso') }}">
@endsection

@section('content')
<div class="terms-page">
    <div class="terms-container">
        <!-- Header da página -->
        <div class="terms-header">
            <div class="terms-header-content">
                <h1>📋 Termos de Uso</h1>
                <p class="terms-subtitle">Última atualização: {{ date('d/m/Y') }}</p>
                <p class="terms-intro">
                    Bem-vindo à Ellon Sports! Ao acessar e utilizar nosso site, você concorda em cumprir e estar vinculado 
                    a estes Termos de Uso. Leia atentamente antes de realizar qualquer compra.
                </p>
            </div>
        </div>

        <!-- Conteúdo principal -->
        <div class="terms-content">
            <!-- Seção 1: Aceitação dos termos -->
            <section class="terms-section">
                <h2>✅ 1. Aceitação dos Termos</h2>
                <div class="terms-card">
                    <h3>1.1 Concordância</h3>
                    <p>Ao acessar, navegar ou utilizar o site da Ellon Sports, você reconhece que leu, 
                    entendeu e concorda em cumprir estes Termos de Uso e nossa Política de Privacidade.</p>
                </div>

                <div class="terms-card">
                    <h3>1.2 Alterações</h3>
                    <p>Reservamo-nos o direito de modificar estes termos a qualquer momento. 
                    Alterações significativas serão comunicadas através do site ou e-mail.</p>
                </div>

                <div class="terms-card">
                    <h3>1.3 Uso Contínuo</h3>
                    <p>O uso contínuo do site após as modificações constitui aceitação dos novos termos.</p>
                </div>
            </section>

            <!-- Seção 2: Descrição dos serviços -->
            <section class="terms-section">
                <h2>🛍️ 2. Descrição dos Serviços</h2>
                <div class="terms-card">
                    <h3>2.1 Nossa Atividade</h3>
                    <p>A Ellon Sports é uma loja online especializada na venda de camisetas de futebol, 
                    oferecendo produtos dos principais times brasileiros e internacionais.</p>
                </div>

                <div class="terms-card">
                    <h3>2.2 Produtos</h3>
                    <ul>
                        <li><strong>Camisetas oficiais</strong> - Produtos licenciados dos times</li>
                        <li><strong>Variedade de tamanhos</strong> - Do P ao GG</li>
                        <li><strong>Times brasileiros</strong> - Principais clubes do Brasil</li>
                        <li><strong>Times internacionais</strong> - Clubes europeus e seleções</li>
                        <li><strong>Produtos exclusivos</strong> - Edições limitadas e especiais</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>2.3 Disponibilidade</h3>
                    <p>Nos reservamos o direito de modificar, suspender ou descontinuar qualquer produto 
                    ou serviço a qualquer momento, sem aviso prévio.</p>
                </div>
            </section>

            <!-- Seção 3: Cadastro e conta -->
            <section class="terms-section">
                <h2>👤 3. Cadastro e Conta do Usuário</h2>
                <div class="terms-card">
                    <h3>3.1 Criação de Conta</h3>
                    <ul>
                        <li><strong>Idade mínima</strong> - 18 anos ou emancipado</li>
                        <li><strong>Dados verdadeiros</strong> - Informações precisas e atualizadas</li>
                        <li><strong>E-mail válido</strong> - Para comunicação e recuperação</li>
                        <li><strong>Senha segura</strong> - Responsabilidade do usuário</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>3.2 Responsabilidades da Conta</h3>
                    <ul>
                        <li><strong>Confidencialidade</strong> - Manter senha em segurança</li>
                        <li><strong>Uso pessoal</strong> - Não compartilhar com terceiros</li>
                        <li><strong>Atualização</strong> - Manter dados sempre atualizados</li>
                        <li><strong>Notificação</strong> - Informar uso não autorizado</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>3.3 Suspensão de Conta</h3>
                    <p>Podemos suspender ou cancelar contas que violem estes termos, 
                    sejam usadas de forma fraudulenta ou causem danos ao site.</p>
                </div>
            </section>

            <!-- Seção 4: Compras e pagamentos -->
            <section class="terms-section">
                <h2>💳 4. Compras e Pagamentos</h2>
                <div class="terms-card">
                    <h3>4.1 Processo de Compra</h3>
                    <ul>
                        <li><strong>Seleção de produtos</strong> - Adicionar ao carrinho</li>
                        <li><strong>Revisão do pedido</strong> - Verificar itens e valores</li>
                        <li><strong>Dados de entrega</strong> - Endereço completo e correto</li>
                        <li><strong>Pagamento</strong> - Métodos aceitos e seguros</li>
                        <li><strong>Confirmação</strong> - E-mail de confirmação</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>4.2 Preços e Taxas</h3>
                    <ul>
                        <li><strong>Preços em reais</strong> - Todos os valores em R$</li>
                        <li><strong>Frete</strong> - Calculado conforme região</li>
                        <li><strong>Impostos</strong> - Inclusos nos preços</li>
                        <li><strong>Alterações</strong> - Preços podem ser alterados</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>4.3 Métodos de Pagamento</h3>
                    <ul>
                        <li><strong>Cartões de crédito</strong> - Visa, Mastercard, Elo</li>
                        <li><strong>Cartões de débito</strong> - Com função crédito</li>
                        <li><strong>PIX</strong> - Pagamento instantâneo</li>
                        <li><strong>Boleto bancário</strong> - Vencimento em 3 dias</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>4.4 Segurança</h3>
                    <p>Todos os pagamentos são processados de forma segura através de gateways 
                    certificados e criptografados.</p>
                </div>
            </section>

            <!-- Seção 5: Entrega -->
            <section class="terms-section">
                <h2>📦 5. Entrega</h2>
                <div class="terms-card">
                    <h3>5.1 Prazos de Entrega</h3>
                    <ul>
                        <li><strong>Processamento</strong> - 1-2 dias úteis</li>
                        <li><strong>Transporte</strong> - 3-10 dias úteis</li>
                        <li><strong>Regiões remotas</strong> - Pode levar mais tempo</li>
                        <li><strong>Feriados</strong> - Prazos podem ser estendidos</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>5.2 Responsabilidades</h3>
                    <ul>
                        <li><strong>Endereço correto</strong> - Responsabilidade do cliente</li>
                        <li><strong>Recebimento</strong> - Assinatura ou autorização</li>
                        <li><strong>Ausência</strong> - Tentativas de reentrega</li>
                        <li><strong>Devolução</strong> - Em caso de não recebimento</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>5.3 Rastreamento</h3>
                    <p>Fornecemos código de rastreamento para acompanhar a entrega 
                    através do e-mail ou área do cliente.</p>
                </div>
            </section>

            <!-- Seção 6: Trocas e devoluções -->
            <section class="terms-section">
                <h2>🔄 6. Trocas e Devoluções</h2>
                <div class="terms-card">
                    <h3>6.1 Direito de Arrependimento</h3>
                    <p>Você tem 7 dias corridos, contados da data de recebimento, 
                    para desistir da compra sem justificativa.</p>
                </div>

                <div class="terms-card">
                    <h3>6.2 Condições para Troca</h3>
                    <ul>
                        <li><strong>Produto íntegro</strong> - Sem uso ou danos</li>
                        <li><strong>Embalagem original</strong> - Etiquetas e lacres</li>
                        <li><strong>Prazo de 30 dias</strong> - Para defeitos de fabricação</li>
                        <li><strong>Documentação</strong> - Nota fiscal obrigatória</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>6.3 Processo de Troca</h3>
                    <ul>
                        {{-- <li><strong>Solicitação</strong> - Via e-mail ou WhatsApp</li> --}}
                        <li><strong>Análise</strong> - Verificação das condições</li>
                        <li><strong>Envio</strong> - Custo por conta do cliente</li>
                        <li><strong>Processamento</strong> - 5-10 dias úteis</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>6.4 Reembolso</h3>
                    <p>O reembolso será processado na mesma forma de pagamento, 
                    em até 2 faturas do cartão ou 5 dias úteis para PIX/boleto.</p>
                </div>
            </section>

            <!-- Seção 7: Uso do site -->
            <section class="terms-section">
                <h2>🌐 7. Uso do Site</h2>
                <div class="terms-card">
                    <h3>7.1 Uso Permitido</h3>
                    <ul>
                        <li><strong>Navegação</strong> - Acesso livre às informações</li>
                        <li><strong>Compras</strong> - Processo de compra normal</li>
                        <li><strong>Conta</strong> - Gerenciamento pessoal</li>
                        <li><strong>Suporte</strong> - Contato para dúvidas</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>7.2 Uso Proibido</h3>
                    <ul>
                        <li><strong>Uso comercial</strong> - Revenda sem autorização</li>
                        <li><strong>Spam</strong> - Mensagens não solicitadas</li>
                        <li><strong>Hacking</strong> - Tentativas de invasão</li>
                        <li><strong>Conteúdo ilegal</strong> - Material inadequado</li>
                        <li><strong>Interferência</strong> - Danos ao funcionamento</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>7.3 Propriedade Intelectual</h3>
                    <p>Todo o conteúdo do site (textos, imagens, logos) é protegido por direitos autorais 
                    e pertence à Ellon Sports ou seus licenciadores.</p>
                </div>
            </section>

            <!-- Seção 8: Limitação de responsabilidade -->
            <section class="terms-section">
                <h2>⚠️ 8. Limitação de Responsabilidade</h2>
                <div class="terms-card">
                    <h3>8.1 Escopo</h3>
                    <p>A Ellon Sports não se responsabiliza por:</p>
                    <ul>
                        <li>Danos indiretos ou consequenciais</li>
                        <li>Perda de lucros ou dados</li>
                        <li>Interrupções temporárias do serviço</li>
                        <li>Ações de terceiros (transportadoras, bancos)</li>
                    </ul>
                </div>

                <div class="terms-card">
                    <h3>8.2 Limite de Indenização</h3>
                    <p>Em caso de responsabilidade comprovada, a indenização será limitada 
                    ao valor pago pelo produto ou serviço.</p>
                </div>

                <div class="terms-card">
                    <h3>8.3 Força Maior</h3>
                    <p>Eventos de força maior (greves, desastres naturais, pandemia) 
                    podem afetar nossos serviços sem responsabilidade nossa.</p>
                </div>
            </section>

            <!-- Seção 9: Lei aplicável -->
            <section class="terms-section">
                <h2>⚖️ 9. Lei Aplicável e Foro</h2>
                <div class="terms-card">
                    <h3>9.1 Jurisdição</h3>
                    <p>Estes termos são regidos pelas leis brasileiras, 
                    especialmente o Código de Defesa do Consumidor.</p>
                </div>

                <div class="terms-card">
                    <h3>9.2 Foro Competente</h3>
                    <p>Qualquer disputa será resolvida no foro da comarca de Alfenas/MG, 
                    salvo se houver foro específico para consumidores.</p>
                </div>

                <div class="terms-card">
                    <h3>9.3 Mediação</h3>
                    <p>Antes de qualquer ação judicial, tentaremos resolver 
                    conflitos através de mediação ou conciliação.</p>
                </div>
            </section>

            <!-- Seção 10: Contato -->
            <section class="terms-section">
                <h2>📞 10. Contato</h2>
                <div class="terms-card contact-card">
                    <h3>10.1 Dúvidas e Suporte</h3>
                    <p>Para dúvidas sobre estes termos ou qualquer questão relacionada aos nossos serviços, 
                    entre em contato conosco:</p>
                    
                    <div class="contact-info">
                        <div class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m4 4 16 0 0 16-16 0z"/>
                                <path d="m22 6-10 7L2 6"/>
                            </svg>
                            <span><strong>E-mail:</strong> suporte@ellonsports.com</span>
                        </div>
                        {{-- <div class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <span><strong>Telefone:</strong> (35) 99999-9999</span>
                        </div> --}}
                        <div class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span><strong>Endereço:</strong> Alfenas, MG - Brasil</span>
                        </div>
                        {{-- <div class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <span><strong>WhatsApp:</strong> (35) 99999-9999</span>
                        </div> --}}
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer da página -->
        <div class="terms-footer">
            <div class="terms-footer-content">
                <p>Estes termos estão em conformidade com o Código de Defesa do Consumidor (CDC) e demais legislações aplicáveis.</p>
                <div class="terms-links">
                    <a href="/politica-privacidade" class="terms-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        Política de Privacidade
                    </a>
                    <a href="/" class="back-home-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m15 18-6-6 6-6"/>
                        </svg>
                        Voltar para a página inicial
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para a página de termos de uso */
.terms-page {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
    padding: 20px 0;
}

.terms-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header da página */
.terms-header {
    background: linear-gradient(135deg, #FF7C00 0%, #FFB800 100%);
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 40px;
    text-align: center;
    color: white;
    box-shadow: 0 10px 30px rgba(255, 124, 0, 0.3);
}

.terms-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    font-family: 'Montserrat', sans-serif;
}

.terms-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 20px;
}

.terms-intro {
    font-size: 1.2rem;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto;
}

/* Conteúdo principal */
.terms-content {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.terms-section {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
}

.terms-section h2 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #FF7C00;
    margin-bottom: 25px;
    font-family: 'Montserrat', sans-serif;
    border-bottom: 3px solid #e2e8f0;
    padding-bottom: 10px;
}

.terms-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
    border-left: 4px solid #FF7C00;
}

.terms-card:last-child {
    margin-bottom: 0;
}

.terms-card h3 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 15px;
    font-family: 'Montserrat', sans-serif;
}

.terms-card ul {
    list-style: none;
    padding: 0;
}

.terms-card li {
    padding: 8px 0;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: flex-start;
}

.terms-card li:last-child {
    border-bottom: none;
}

.terms-card li::before {
    content: "✓";
    color: #FF7C00;
    font-weight: bold;
    margin-right: 10px;
    font-size: 1.1rem;
}

.terms-card p {
    line-height: 1.6;
    color: #475569;
    margin-bottom: 15px;
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
    align-items: center;
    gap: 12px;
    padding: 15px;
    background: white;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.contact-item svg {
    color: #FF7C00;
    flex-shrink: 0;
}

.contact-item span {
    color: #1e293b;
    font-weight: 500;
}

/* Footer da página */
.terms-footer {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-top: 40px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
}

.terms-footer p {
    color: #64748b;
    margin-bottom: 20px;
    font-size: 1.1rem;
}

.terms-links {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.terms-link {
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

.terms-link:hover {
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
    .terms-container {
        padding: 0 15px;
    }
    
    .terms-header {
        padding: 30px 20px;
        margin-bottom: 30px;
    }
    
    .terms-header h1 {
        font-size: 2rem;
    }
    
    .terms-section {
        padding: 20px;
    }
    
    .terms-card {
        padding: 20px;
    }
    
    .contact-info {
        gap: 10px;
    }
    
    .contact-item {
        padding: 12px;
        flex-direction: column;
        text-align: center;
        gap: 8px;
    }
    
    .terms-links {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .terms-header h1 {
        font-size: 1.8rem;
    }
    
    .terms-intro {
        font-size: 1rem;
    }
    
    .terms-section h2 {
        font-size: 1.5rem;
    }
    
    .terms-card h3 {
        font-size: 1.2rem;
    }
}
</style>
@endsection 