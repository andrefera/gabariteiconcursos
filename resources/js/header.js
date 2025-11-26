// Header Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('product-search-input');
    const dropdown = document.getElementById('search-results-dropdown');
    let timeout = null;

    if (!input || !dropdown) return;

    input.addEventListener('input', function() {
        clearTimeout(timeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            dropdown.style.display = 'none';
            dropdown.innerHTML = '';
            return;
        }
        
        timeout = setTimeout(() => {
            fetch(`/search/products?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(products => {
                    if (products.length === 0) {
                        dropdown.innerHTML = '<div class="no-results">Nenhum produto encontrado.</div>';
                    } else {
                        dropdown.innerHTML = products.map(product => `
                            <a class="search-result-item" href="${product.url}">
                                <img src="${product.image ?? '/images/no-image.png'}" alt="${product.name}" width="70" height="70">
                                <div>
                                    <strong>${product.name}</strong><br>
                                    <span>${product.sku ?? ''}</span>
                                </div>
                            </a>
                        `).join('');
                    }
                    dropdown.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error searching products:', error);
                    dropdown.innerHTML = '<div class="no-results">Erro ao buscar produtos.</div>';
                    dropdown.style.display = 'block';
                });
        }, 300); // debounce
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target) && e.target !== input) {
            dropdown.style.display = 'none';
        }
    });

    // Hide dropdown when pressing Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            dropdown.style.display = 'none';
            input.blur();
        }
    });
});

// Enhanced Dropdown Menus Functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropdownMenus = document.querySelectorAll('.dropdown-menu');
    let activeDropdown = null;
    let hoverTimeout = null;
    let closeTimeout = null;
    const HOVER_DELAY = 150;
    const CLOSE_DELAY = 300;

    // Enhanced function to close all dropdowns with smooth animation
    function closeAllDropdowns(immediate = false) {
        if (closeTimeout) {
            clearTimeout(closeTimeout);
            closeTimeout = null;
        }

        dropdownMenus.forEach(menu => {
            const content = menu.querySelector('.dropdown-content');
            const trigger = menu.querySelector('.dropdown-trigger');
            const arrow = trigger?.querySelector('img');
            
            if (content && content.classList.contains('show')) {
                // Remove show class to trigger closing animation
                content.classList.remove('show');
                content.classList.add('closing');
                menu.classList.remove('active', 'opening');
                menu.classList.add('closing');
                
                if (trigger) {
                    trigger.classList.remove('active');
                }
                
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }

                // Hide after animation completes
                const delay = immediate ? 0 : 250;
                setTimeout(() => {
                    if (!content.classList.contains('show')) {
                        content.style.display = 'none';
                        content.classList.remove('closing');
                        menu.classList.remove('closing');
                    }
                }, delay);
            }
        });
        activeDropdown = null;
    }

    // Enhanced function to open a specific dropdown
    function openDropdown(menu, withDelay = false) {
        if (hoverTimeout) {
            clearTimeout(hoverTimeout);
            hoverTimeout = null;
        }

        const executeOpen = () => {
            // Close others first
            closeAllDropdowns(true);
            
            const content = menu.querySelector('.dropdown-content');
            const trigger = menu.querySelector('.dropdown-trigger');
            const arrow = trigger?.querySelector('img');
            
            if (content) {
                // Prepare for opening animation
                content.style.display = 'block';
                content.classList.remove('closing');
                menu.classList.remove('closing');
                menu.classList.add('active', 'opening');
                activeDropdown = menu;
                
                if (trigger) {
                    trigger.classList.add('active');
                }
                
                if (arrow) {
                    arrow.style.transform = 'rotate(180deg)';
                }

                // Trigger opening animation
                requestAnimationFrame(() => {
                    content.classList.add('show');
                    setTimeout(() => {
                        menu.classList.remove('opening');
                    }, 250);
                });
            }
        };

        if (withDelay) {
            hoverTimeout = setTimeout(executeOpen, HOVER_DELAY);
        } else {
            executeOpen();
        }
    }

    // Enhanced toggle function
    function toggleDropdown(menu) {
        const content = menu.querySelector('.dropdown-content');
        const isOpen = content && content.classList.contains('show');
        
        if (isOpen) {
            closeAllDropdowns();
        } else {
            openDropdown(menu);
        }
    }

    // Function to schedule closing with delay
    function scheduleClose(delay = CLOSE_DELAY) {
        if (closeTimeout) {
            clearTimeout(closeTimeout);
        }
        closeTimeout = setTimeout(() => {
            closeAllDropdowns();
        }, delay);
    }

    // Function to cancel scheduled close
    function cancelScheduledClose() {
        if (closeTimeout) {
            clearTimeout(closeTimeout);
            closeTimeout = null;
        }
    }

    // Enhanced event listeners for each dropdown
    dropdownMenus.forEach(menu => {
        const trigger = menu.querySelector('.dropdown-trigger');
        const content = menu.querySelector('.dropdown-content');
        
        if (trigger) {
            // Click handler - works on all devices
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                cancelScheduledClose();
                toggleDropdown(menu);
            });

            // Touch handlers for better mobile experience
            menu.addEventListener('touchstart', function(e) {
                const isOpen = content && content.classList.contains('show');
                if (!isOpen) {
                    e.preventDefault();
                    openDropdown(menu);
                }
            }, { passive: false });
        }
    });

    // Enhanced outside click handler
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-menu')) {
            closeAllDropdowns();
        }
    });

    // Enhanced keyboard navigation
    document.addEventListener('keydown', function(e) {
        switch(e.key) {
            case 'Escape':
                closeAllDropdowns();
                break;
            case 'ArrowDown':
                if (activeDropdown) {
                    e.preventDefault();
                    const firstLink = activeDropdown.querySelector('.dropdown-content a');
                    if (firstLink) firstLink.focus();
                }
                break;
        }
    });

    // Handle window resize with debounce
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            closeAllDropdowns();
        }, 100);
    });

    // Add focus management for accessibility
    dropdownMenus.forEach(menu => {
        const content = menu.querySelector('.dropdown-content');
        if (content) {
            const links = content.querySelectorAll('a');
            links.forEach((link, index) => {
                link.addEventListener('keydown', function(e) {
                    if (e.key === 'ArrowDown' && index < links.length - 1) {
                        e.preventDefault();
                        links[index + 1].focus();
                    } else if (e.key === 'ArrowUp' && index > 0) {
                        e.preventDefault();
                        links[index - 1].focus();
                    } else if (e.key === 'Escape') {
                        closeAllDropdowns();
                        menu.querySelector('.dropdown-trigger').focus();
                    }
                });
            });
        }
    });
});

// Mobile Sidebar Functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing sidebar functionality...');
    
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const sidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const sidebarClose = document.getElementById('sidebar-close');
    const sidebarSectionTriggers = document.querySelectorAll('.sidebar-section-trigger');
    
    console.log('Sidebar elements found:', {
        mobileMenuBtn: !!mobileMenuBtn,
        sidebar: !!sidebar,
        sidebarOverlay: !!sidebarOverlay,
        sidebarClose: !!sidebarClose,
        sectionTriggers: sidebarSectionTriggers.length
    });

    // Check if elements exist
    if (!mobileMenuBtn || !sidebar) {
        console.warn('Sidebar elements not found');
        return;
    }

    let activeSidebarSection = null;

    // Open sidebar
    function openSidebar() {
        console.log('Opening sidebar...');
        sidebar.classList.add('active');
        mobileMenuBtn.classList.add('active');
        document.body.classList.add('sidebar-open');
    }

    // Close sidebar
    function closeSidebar() {
        console.log('Closing sidebar...');
        sidebar.classList.remove('active');
        mobileMenuBtn.classList.remove('active');
        document.body.classList.remove('sidebar-open');
        closeAllSections();
    }

    // Toggle sidebar section
    function toggleSidebarSection(sectionTrigger) {
        const sectionName = sectionTrigger.dataset.section;
        const sectionContent = document.getElementById(`${sectionName}-content`);
        
        console.log(`Toggling section: ${sectionName}`, {
            trigger: !!sectionTrigger,
            content: !!sectionContent
        });
        
        if (!sectionContent) {
            console.warn(`Section content not found: ${sectionName}-content`);
            return;
        }

        const isActive = sectionContent.classList.contains('active');
        
        // Close all sections first
        closeAllSections();
        
        // If this section wasn't active, open it
        if (!isActive) {
            console.log(`Opening section: ${sectionName}`);
            sectionTrigger.classList.add('active');
            sectionContent.classList.add('active');
            activeSidebarSection = sectionName;
        } else {
            console.log(`Section ${sectionName} was already active, closing all`);
        }
    }

    // Close all sidebar sections
    function closeAllSections() {
        console.log('Closing all sections...');
        sidebarSectionTriggers.forEach(trigger => {
            trigger.classList.remove('active');
            const sectionName = trigger.dataset.section;
            const sectionContent = document.getElementById(`${sectionName}-content`);
            if (sectionContent) {
                sectionContent.classList.remove('active');
            }
        });
        activeSidebarSection = null;
    }

    // Mobile menu button click
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Menu button clicked');
            
            if (sidebar.classList.contains('active')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    // Sidebar close button
    if (sidebarClose) {
        sidebarClose.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Close button clicked');
            closeSidebar();
        });
    }

    // Overlay click to close
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Overlay clicked');
            closeSidebar();
        });
    }

    // Section triggers
    sidebarSectionTriggers.forEach((trigger, index) => {
        console.log(`Setting up trigger ${index}:`, trigger.dataset.section);
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log(`Section trigger clicked: ${trigger.dataset.section}`);
            toggleSidebarSection(this);
        });
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('active')) {
            console.log('Escape key pressed, closing sidebar');
            closeSidebar();
        }
    });

    // Close sidebar when clicking on sidebar links
    const sidebarLinks = sidebar.querySelectorAll('.sidebar-section-content a, .sidebar-action-btn');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            console.log('Sidebar link clicked, closing sidebar');
            setTimeout(() => {
                closeSidebar();
            }, 150);
        });
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sidebar.classList.contains('active')) {
            console.log('Switched to desktop, closing sidebar');
            closeSidebar();
        }
    });

    // Simple touch gesture to close sidebar (swipe left)
    let touchStartX = 0;

    if (sidebar) {
        sidebar.addEventListener('touchstart', function(e) {
            touchStartX = e.touches[0].clientX;
        });

        sidebar.addEventListener('touchend', function(e) {
            const touchEndX = e.changedTouches[0].clientX;
            const deltaX = touchStartX - touchEndX;
            
            // If swiped left more than 100px, close sidebar
            if (deltaX > 100) {
                console.log('Swipe left detected, closing sidebar');
                closeSidebar();
            }
        });
    }

    console.log('Sidebar initialization complete');
});