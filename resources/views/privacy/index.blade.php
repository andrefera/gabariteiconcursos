@extends('layouts.app')

@section('title', 'Política de Privacidade - Ellon Sports')

@section('meta-tags')
    <meta name="description" content="Conheça nossa política de privacidade e como protegemos seus dados pessoais na Ellon Sports.">
    <meta name="keywords" content="política de privacidade, dados pessoais, proteção de dados, LGPD, Ellon Sports">
    <meta property="og:title" content="Política de Privacidade - Ellon Sports">
    <meta property="og:description" content="Conheça nossa política de privacidade e como protegemos seus dados pessoais.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/politica-privacidade') }}">
@endsection

@section('content')
<div class="privacy-page">
    <div class="privacy-container">
        <!-- Header da página -->
        <div class="privacy-header">
            <div class="privacy-header-content">
                <h1>🔒 Política de Privacidade</h1>
                <p class="privacy-subtitle">Última atualização: {{ date('d/m/Y') }}</p>
                <p class="privacy-intro">
                    A Ellon Sports está comprometida em proteger sua privacidade e garantir a segurança de seus dados pessoais. 
                    Esta política descreve como coletamos, usamos e protegemos suas informações.
                </p>
            </div>
        </div>

        <!-- Conteúdo principal -->
        <div class="privacy-content">
            <!-- Seção 1: Informações que coletamos -->
            <section class="privacy-section">
                <h2>📋 1. Informações que Coletamos</h2>
                <div class="privacy-card">
                    <h3>1.1 Informações Pessoais</h3>
                    <ul>
                        <li><strong>Nome completo</strong> - Para identificação e entrega</li>
                        <li><strong>E-mail</strong> - Para comunicação e recuperação de conta</li>
                        <li><strong>Telefone</strong> - Para contato sobre pedidos</li>
                        <li><strong>CPF</strong> - Para emissão de notas fiscais</li>
                        <li><strong>Endereço</strong> - Para entrega dos produtos</li>
                    </ul>
                </div>

                <div class="privacy-card">
                    <h3>1.2 Informações de Navegação</h3>
                    <ul>
                        <li><strong>Endereço IP</strong> - Para segurança e análise</li>
                        <li><strong>Cookies</strong> - Para melhorar sua experiência</li>
                        <li><strong>Dados de navegação</strong> - Para personalização</li>
                        <li><strong>Dispositivo utilizado</strong> - Para otimização</li>
                    </ul>
                </div>

                <div class="privacy-card">
                    <h3>1.3 Informações de Compra</h3>
                    <ul>
                        <li><strong>Histórico de pedidos</strong> - Para atendimento</li>
                        <li><strong>Preferências de produtos</strong> - Para recomendações</li>
                        <li><strong>Dados de pagamento</strong> - Processados de forma segura</li>
                    </ul>
                </div>
            </section>

            <!-- Seção 2: Como usamos suas informações -->
            <section class="privacy-section">
                <h2>🎯 2. Como Usamos Suas Informações</h2>
                <div class="privacy-card">
                    <h3>2.1 Finalidades Principais</h3>
                    <ul>
                        <li><strong>Processamento de pedidos</strong> - Para entregar seus produtos</li>
                        <li><strong>Comunicação</strong> - Para informar sobre status de pedidos</li>
                        <li><strong>Atendimento ao cliente</strong> - Para resolver dúvidas e problemas</li>
                        <li><strong>Melhorias no site</strong> - Para otimizar sua experiência</li>
                        <li><strong>Marketing</strong> - Para enviar ofertas relevantes (com seu consentimento)</li>
                    </ul>
                </div>

                <div class="privacy-card">
                    <h3>2.2 Base Legal</h3>
                    <p>Utilizamos suas informações com base em:</p>
                    <ul>
                        <li><strong>Execução de contrato</strong> - Para cumprir nossos serviços</li>
                        <li><strong>Interesse legítimo</strong> - Para melhorar nossos serviços</li>
                        <li><strong>Consentimento</strong> - Para marketing e cookies</li>
                        <li><strong>Obrigação legal</strong> - Para cumprir leis aplicáveis</li>
                    </ul>
                </div>
            </section>

            <!-- Seção 3: Compartilhamento de dados -->
            <section class="privacy-section">
                <h2>🤝 3. Compartilhamento de Dados</h2>
                <div class="privacy-card">
                    <h3>3.1 Quando Compartilhamos</h3>
                    <ul>
                        <li><strong>Prestadores de serviços</strong> - Para entrega e pagamento</li>
                        <li><strong>Autoridades</strong> - Quando exigido por lei</li>
                        <li><strong>Parceiros de marketing</strong> - Apenas com seu consentimento</li>
                    </ul>
                </div>

                <div class="privacy-card">
                    <h3>3.2 Proteção</h3>
                    <p>Nunca vendemos, alugamos ou comercializamos seus dados pessoais. 
                    Todos os parceiros são obrigados a manter a confidencialidade das informações.</p>
                </div>
            </section>

            <!-- Seção 4: Segurança -->
            <section class="privacy-section">
                <h2>🛡️ 4. Segurança dos Dados</h2>
                <div class="privacy-card">
                    <h3>4.1 Medidas de Proteção</h3>
                    <ul>
                        <li><strong>Criptografia SSL</strong> - Para transmissão segura</li>
                        <li><strong>Firewalls</strong> - Para proteção contra ataques</li>
                        <li><strong>Monitoramento 24/7</strong> - Para detectar ameaças</li>
                        <li><strong>Backup regular</strong> - Para preservar dados</li>
                        <li><strong>Treinamento da equipe</strong> - Para boas práticas</li>
                    </ul>
                </div>

                <div class="privacy-card">
                    <h3>4.2 Retenção de Dados</h3>
                    <p>Mantemos seus dados apenas pelo tempo necessário para:</p>
                    <ul>
                        <li>Cumprir obrigações legais</li>
                        <li>Resolver disputas</li>
                        <li>Executar nossos serviços</li>
                        <li>Melhorar nossos produtos</li>
                    </ul>
                </div>
            </section>

            <!-- Seção 5: Seus direitos -->
            <section class="privacy-section">
                <h2>⚖️ 5. Seus Direitos</h2>
                <div class="privacy-card">
                    <h3>5.1 Direitos LGPD</h3>
                    <ul>
                        <li><strong>Acesso</strong> - Solicitar informações sobre seus dados</li>
                        <li><strong>Correção</strong> - Atualizar dados incorretos</li>
                        <li><strong>Exclusão</strong> - Solicitar remoção de dados</li>
                        <li><strong>Portabilidade</strong> - Receber dados em formato estruturado</li>
                        <li><strong>Revogação</strong> - Cancelar consentimentos</li>
                        <li><strong>Oposição</strong> - Contestar o uso de dados</li>
                    </ul>
                </div>

                <div class="privacy-card">
                    <h3>5.2 Como Exercer Seus Direitos</h3>
                    <p>Para exercer qualquer um desses direitos, entre em contato conosco:</p>
                    <ul>
                        <li><strong>E-mail:</strong> privacidade@ellonsports.com</li>
                        {{-- <li><strong>Telefone:</strong> (35) 99999-9999</li> --}}
                        <li><strong>Endereço:</strong> Alfenas, MG - Brasil</li>
                    </ul>
                    <p>Responderemos em até 15 dias úteis.</p>
                </div>
            </section>

            <!-- Seção 6: Cookies -->
            <section class="privacy-section">
                <h2>🍪 6. Cookies e Tecnologias Similares</h2>
                <div class="privacy-card">
                    <h3>6.1 Tipos de Cookies</h3>
                    <ul>
                        <li><strong>Essenciais</strong> - Necessários para o funcionamento do site</li>
                        <li><strong>Analíticos</strong> - Para entender como você usa o site</li>
                        <li><strong>Funcionais</strong> - Para lembrar suas preferências</li>
                        <li><strong>Marketing</strong> - Para mostrar anúncios relevantes</li>
                    </ul>
                </div>

                <div class="privacy-card">
                    <h3>6.2 Gerenciamento de Cookies</h3>
                    <p>Você pode controlar os cookies através das configurações do seu navegador. 
                    No entanto, desabilitar cookies essenciais pode afetar a funcionalidade do site.</p>
                </div>
            </section>

            <!-- Seção 7: Menores de idade -->
            <section class="privacy-section">
                <h2>👶 7. Proteção de Menores</h2>
                <div class="privacy-card">
                    <h3>7.1 Idade Mínima</h3>
                    <p>Nossos serviços não são destinados a menores de 18 anos. 
                    Não coletamos intencionalmente dados pessoais de menores de idade.</p>
                </div>

                <div class="privacy-card">
                    <h3>7.2 Responsabilidade</h3>
                    <p>Se você é responsável por um menor que forneceu dados pessoais, 
                    entre em contato conosco para solicitar a remoção dessas informações.</p>
                </div>
            </section>

            <!-- Seção 8: Alterações -->
            <section class="privacy-section">
                <h2>📝 8. Alterações na Política</h2>
                <div class="privacy-card">
                    <h3>8.1 Atualizações</h3>
                    <p>Podemos atualizar esta política periodicamente. 
                    Alterações significativas serão comunicadas através de:</p>
                    <ul>
                        <li>Notificação no site</li>
                        <li>E-mail para usuários cadastrados</li>
                        <li>Banner de aviso</li>
                    </ul>
                </div>

                <div class="privacy-card">
                    <h3>8.2 Aceitação</h3>
                    <p>Ao continuar usando nossos serviços após as alterações, 
                    você concorda com a nova política de privacidade.</p>
                </div>
            </section>

            <!-- Seção 9: Contato -->
            <section class="privacy-section">
                <h2>📞 9. Contato</h2>
                <div class="privacy-card contact-card">
                    <h3>9.1 Dúvidas e Solicitações</h3>
                    <p>Se você tiver dúvidas sobre esta política ou quiser exercer seus direitos, 
                    entre em contato conosco:</p>
                    
                    <div class="contact-info">
                        <div class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m4 4 16 0 0 16-16 0z"/>
                                <path d="m22 6-10 7L2 6"/>
                            </svg>
                            <span><strong>E-mail:</strong> privacidade@ellonsports.com</span>
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
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer da página -->
        <div class="privacy-footer">
            <div class="privacy-footer-content">
                <p>Esta política está em conformidade com a Lei Geral de Proteção de Dados (LGPD) - Lei nº 13.709/2018.</p>
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

<style>
/* Estilos para a página de política de privacidade */
.privacy-page {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
    padding: 20px 0;
}

.privacy-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header da página */
.privacy-header {
    background: linear-gradient(135deg, #FF7C00 0%, #FFB800 100%);
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 40px;
    text-align: center;
    color: white;
    box-shadow: 0 10px 30px rgba(255, 124, 0, 0.3);
}

.privacy-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    font-family: 'Montserrat', sans-serif;
}

.privacy-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 20px;
}

.privacy-intro {
    font-size: 1.2rem;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto;
}

/* Conteúdo principal */
.privacy-content {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.privacy-section {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
}

.privacy-section h2 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #FF7C00;
    margin-bottom: 25px;
    font-family: 'Montserrat', sans-serif;
    border-bottom: 3px solid #e2e8f0;
    padding-bottom: 10px;
}

.privacy-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
    border-left: 4px solid #FF7C00;
}

.privacy-card:last-child {
    margin-bottom: 0;
}

.privacy-card h3 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 15px;
    font-family: 'Montserrat', sans-serif;
}

.privacy-card ul {
    list-style: none;
    padding: 0;
}

.privacy-card li {
    padding: 8px 0;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: flex-start;
}

.privacy-card li:last-child {
    border-bottom: none;
}

.privacy-card li::before {
    content: "✓";
    color: #FF7C00;
    font-weight: bold;
    margin-right: 10px;
    font-size: 1.1rem;
}

.privacy-card p {
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
.privacy-footer {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-top: 40px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
}

.privacy-footer p {
    color: #64748b;
    margin-bottom: 20px;
    font-size: 1.1rem;
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
    .privacy-container {
        padding: 0 15px;
    }
    
    .privacy-header {
        padding: 30px 20px;
        margin-bottom: 30px;
    }
    
    .privacy-header h1 {
        font-size: 2rem;
    }
    
    .privacy-section {
        padding: 20px;
    }
    
    .privacy-card {
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
}

@media (max-width: 480px) {
    .privacy-header h1 {
        font-size: 1.8rem;
    }
    
    .privacy-intro {
        font-size: 1rem;
    }
    
    .privacy-section h2 {
        font-size: 1.5rem;
    }
    
    .privacy-card h3 {
        font-size: 1.2rem;
    }
}
</style>
@endsection 