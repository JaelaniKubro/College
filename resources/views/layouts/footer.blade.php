    <!-- Footer -->
    <footer id="kontak">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h4>Tentang Kami</h4>
                    <p>Dinas Kebudayaan, Pariwisata, Pemuda, dan Olahraga (Disbudparpora) Kabupaten Ponorogo berkomitmen untuk mengembangkan dan mempromosikan potensi wisata, budaya, dan olahraga di Ponorogo.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h4>Kontak Kami</h4>
                    <ul>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Jalan Pramuka No.19 A Ponorogo Jawa Timur 63419</li>
                        <li><i class="fas fa-phone me-2"></i> (0352) 486012</li>
                        <li><i class="fas fa-envelope me-2"></i> info@disbudparpora.ponorogo.go.id</li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2025 Disbudparpora Ponorogo. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Ticket Confirmation Modal -->
    <div class="modal fade" id="ticketConfirmationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pemesanan Tiket</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="ticket-confirmation">
                        <i class="fas fa-check-circle"></i>
                        <h4>Pemesanan Berhasil!</h4>
                        <p>Tiket Anda telah berhasil dipesan. Detail tiket telah dikirim ke email Anda.</p>
                        
                        <div class="ticket-details">
                            <h5>Detail Pemesanan</h5>
                            <div class="summary-item">
                                <span>Nama</span>
                                <span id="confirmName">-</span>
                            </div>
                            <div class="summary-item">
                                <span>Tanggal Kunjungan</span>
                                <span id="confirmDate">-</span>
                            </div>
                            <div class="summary-item">
                                <span>Jumlah Tiket</span>
                                <span id="confirmQuantity">-</span>
                            </div>
                            <div class="summary-item summary-total">
                                <span>Total Pembayaran</span>
                                <span id="confirmTotal">-</span>
                            </div>
                        </div>
                        
                        <p class="small text-muted">Silakan tunjukkan bukti pemesanan ini di loket tiket Telaga Ngebel.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="hero-btn" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="hero-btn" style="background-color: transparent; border: 2px solid var(--primary-color); color: var(--primary-color);"><i class="fas fa-print me-2"></i>Cetak Tiket</button>
                </div>
            </div>
        </div>
    </div>
        
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });
        
        // Mobile menu toggle
        $('.mobile-menu-toggle').click(function(){
            $('.nav-menu').toggleClass('active');
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Ticket price calculation
        const ticketPrice = 15000;
        const ticketCount = document.getElementById('ticketCount');
        const ticketPriceElement = document.getElementById('ticketPrice');
        const ticketQuantityElement = document.getElementById('ticketQuantity');
        const totalPriceElement = document.getElementById('totalPrice');
        
        function updateTicketSummary() {
            const count = parseInt(ticketCount.value) || 0;
            const total = count * ticketPrice;
            
            ticketPriceElement.textContent = `Rp ${ticketPrice.toLocaleString('id-ID')}`;
            ticketQuantityElement.textContent = count;
            totalPriceElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }
        
        if (ticketCount) {
            ticketCount.addEventListener('change', updateTicketSummary);
        }
        
        // Set minimum date to today
        const visitDate = document.getElementById('visitDate');
        if (visitDate) {
            const today = new Date().toISOString().split('T')[0];
            visitDate.min = today;
        }
        
        // Form submission
        const ticketForm = document.getElementById('ticketForm');
        if (ticketForm) {
            ticketForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form values
                const name = document.getElementById('fullName').value;
                const date = document.getElementById('visitDate').value;
                const quantity = document.getElementById('ticketCount').value;
                const total = parseInt(quantity) * ticketPrice;
                
                // Set confirmation values
                document.getElementById('confirmName').textContent = name;
                document.getElementById('confirmDate').textContent = new Date(date).toLocaleDateString('id-ID');
                document.getElementById('confirmQuantity').textContent = quantity;
                document.getElementById('confirmTotal').textContent = `Rp ${total.toLocaleString('id-ID')}`;
                
                // Show confirmation modal
                const confirmationModal = new bootstrap.Modal(document.getElementById('ticketConfirmationModal'));
                confirmationModal.show();
                
                // Reset form
                ticketForm.reset();
                updateTicketSummary();
            });
        }
        
        // Initialize ticket summary
        if (ticketCount) {
            updateTicketSummary();
        }
        
        // Ticket form functionality untuk halaman tiket.php
    const ticketFormNew = document.getElementById('ticketForm');
    if (ticketFormNew) {
        // Initialize ticket summary
        updateTicketSummary();
        
        // Set minimum date to today
        const visitDate = document.getElementById('visitDate');
        if (visitDate) {
            const today = new Date().toISOString().split('T')[0];
            visitDate.min = today;
        }
        
        // Form submission
        ticketFormNew.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const name = document.getElementById('fullName').value;
            const date = document.getElementById('visitDate').value;
            const quantity = document.getElementById('ticketCount').value;
            const total = parseInt(quantity) * ticketPrice;
            
            // Set confirmation values
            document.getElementById('confirmName').textContent = name;
            document.getElementById('confirmDate').textContent = new Date(date).toLocaleDateString('id-ID');
            document.getElementById('confirmQuantity').textContent = quantity;
            document.getElementById('confirmTotal').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            
            // Show confirmation modal
            const confirmationModal = new bootstrap.Modal(document.getElementById('ticketConfirmationModal'));
            confirmationModal.show();
            
            // Reset form
            ticketFormNew.reset();
            updateTicketSummary();
        });
    }
    </script>
</body>
</html>