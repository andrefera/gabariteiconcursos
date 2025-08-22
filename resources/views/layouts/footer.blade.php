<!-- 🏆 FOOTER MODERNO - ELLON SPORTS E-COMMERCE -->
<footer id="modern-footer">
    <div class="footer-main">
        <div class="footer-container">
            <!-- 📧 NEWSLETTER SECTION -->
            <div class="newsletter-section">
                <div class="alignSection">
                    <div class="newsletter-content">
                        <div class="newsletter-text">
                            <h3>🏆 Fique por dentro das novidades!</h3>
                            <p>Receba ofertas exclusivas, lançamentos e novidades do mundo esportivo diretamente no seu
                                e-mail</p>
                        </div>
                        <form class="newsletter-form" action="#" method="POST">
                            @csrf
                            <div class="newsletter-input-group">
                                <input type="email" name="email" placeholder="Digite seu e-mail"
                                       class="newsletter-input" required>
                                <button type="submit" class="newsletter-btn">
                                    <span>Inscrever-se</span>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2">
                                        <path d="m9 18 6-6-6-6"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="newsletter-disclaimer">Ao se inscrever, você concorda com nossa política de
                                privacidade</p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="alignSection">
                <!-- 📋 MAIN FOOTER CONTENT -->
                <div class="footer-content">

                    <!-- 🏢 COMPANY INFO -->
                    <div class="footer-column footer-company">
                        <div class="footer-logo">
                            <img src="{{ asset('logo.png') }}" alt="Ellon Sports" class="footer-logo-img">
{{--                            <h3>Ellon Sports</h3>--}}
                        </div>
                        <p class="footer-description">
                            Sua loja especializada em camisetas de futebol. Produtos dos principais
                            times brasileiros e internacionais.
                        </p>
                        <div class="footer-contact-info">
                            <div class="contact-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                <span>Alfenas, MG - Brasil</span>
                            </div>
                            <div class="contact-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                <a href="tel:+5511999999999">(35) 99999-9999</a>
                            </div>
                            <div class="contact-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2">
                                    <path d="m4 4 16 0 0 16-16 0z"/>
                                    <path d="m22 6-10 7L2 6"/>
                                </svg>
                                <a href="mailto:contato@ellonsports.com">contato@ellonsports.com</a>
                            </div>
                        </div>
                    </div>

                    <!-- 🛍️ SHOP LINKS -->
                    <div class="footer-column">
                        <h4>🛍️ Comprar</h4>
                        <ul class="footer-links">
                            <li><a href="/brasileiros">⚽ Times Brasileiros</a></li>
                            <li><a href="/internacionais">🌍 Times Internacionais</a></li>
                            <li><a href="/selecoes">🏆 Seleções</a></li>
                            <li><a href="/lancamentos">🆕 Lançamentos</a></li>
                            <li><a href="/promocoes">🔥 Promoções</a></li>
                        </ul>
                    </div>

                    <!-- ❓ HELP & SUPPORT -->
                    <div class="footer-column">
                        <h4>❓ Ajuda</h4>
                        <ul class="footer-links">
                            <li><a href="/sobre">📖 Sobre Nós</a></li>
                            <li><a href="/atendimento">📞 Atendimento</a></li>
                            <li><a href="/trocas-devolucoes">🔄 Trocas e Devoluções</a></li>
                            <li><a href="/frete">📦 Cálculo de Frete</a></li>
                            <li><a href="/pagamento">💳 Formas de Pagamento</a></li>
                        </ul>
                    </div>

                    <!-- 📱 SOCIAL & APPS -->
                    <div class="footer-column footer-social">
                        <h4>📱 Conecte-se</h4>
                        <p class="social-description">Siga nossas redes sociais e não perca nenhuma novidade!</p>
                        <div class="social-links">
                            <a href="#" class="social-link facebook" title="Facebook">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="social-link instagram" title="Instagram">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a href="#" class="social-link twitter" title="Twitter">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="#" class="social-link youtube" title="YouTube">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            <a href="#" class="social-link whatsapp" title="WhatsApp">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.891 3.488"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <!-- 💳 PAYMENT & SECURITY -->--}}
    {{--    <div class="footer-payment">--}}
    {{--        <div class="footer-container">--}}
    {{--            <div class="payment-content">--}}
    {{--                <div class="payment-methods">--}}
    {{--                    <h5>💳 Formas de Pagamento</h5>--}}
    {{--                    <div class="payment-icons">--}}
    {{--                        <div class="payment-icon visa" title="Visa"></div>--}}
    {{--                        <div class="payment-icon mastercard" title="Mastercard"></div>--}}
    {{--                        <div class="payment-icon amex" title="American Express"></div>--}}
    {{--                        <div class="payment-icon elo" title="Elo"></div>--}}
    {{--                        <div class="payment-icon pix" title="PIX">PIX</div>--}}
    {{--                        <div class="payment-icon boleto" title="Boleto">Boleto</div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="security-badges">--}}
    {{--                    <h5>🔒 Segurança & Certificações</h5>--}}
    {{--                    <div class="security-icons">--}}
    {{--                        <div class="security-badge ssl" title="SSL Certificado">--}}
    {{--                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"--}}
    {{--                                 stroke-width="2">--}}
    {{--                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>--}}
    {{--                                <circle cx="12" cy="16" r="1"/>--}}
    {{--                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>--}}
    {{--                            </svg>--}}
    {{--                            <span>SSL</span>--}}
    {{--                        </div>--}}
    {{--                        <div class="security-badge pci" title="PCI Compliant">--}}
    {{--                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"--}}
    {{--                                 stroke-width="2">--}}
    {{--                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>--}}
    {{--                                <path d="m9 12 2 2 4-4"/>--}}
    {{--                            </svg>--}}
    {{--                            <span>PCI</span>--}}
    {{--                        </div>--}}
    {{--                        <div class="security-badge reclame-aqui" title="Reclame Aqui">--}}
    {{--                            <span>RA</span>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <!-- 📜 FOOTER BOTTOM -->
    <div class="footer-bottom">
        <div class="alignSection">
            <div class="footer-container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; {{ date('Y') }} <strong>Ellon Sports</strong>. Todos os direitos reservados.</p>
                        <p class="cnpj">CNPJ: 00.000.000/0001-00</p>
                    </div>
                    <div class="legal-links">
                        <a href="/politica-privacidade">Política de Privacidade</a>
                        <span class="separator">•</span>
                        <a href="/termos-uso">Termos de Uso</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@yield('footer_content')
