<footer class="bg-dark text-white pt-4 mt-5">
    <div class="container">
        <div class="row">
            <!-- Quick Links -->
            <div class="col-md-3">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="login.php" class="text-white text-decoration-none">Reporter Login</a></li>
                    <li><a href="manager_login.php" class="text-white text-decoration-none">Manager Login</a></li>
                    <li><a href="incident_report_form.php" class="text-white text-decoration-none">IR Form</a></li>
                    <li><a href="ir_guidelines.php" class="text-white text-decoration-none">IR Guidelines</a></li>
                    <!-- <li><a href="escalation_procedures.php" class="text-white text-decoration-none">Escalation Procedures</a></li> -->
                </ul>
            </div>

            <!-- Social Media Icons -->
        <div class="col-md-3">
            <h5>Follow Us</h5>
            <a href="#" class="text-white me-2"><i class="fab fa-facebook fa-lg"></i></a>
            <a href="#" class="text-white me-2"><i class="fab fa-twitter fa-lg"></i></a>
            <a href="#" class="text-white me-2"><i class="fab fa-instagram fa-lg"></i></a>
            <a href="#" class="text-white me-2"><i class="fab fa-youtube fa-lg"></i></a>
        </div>


            <!-- Contact Information & Map -->
            <div class="col-md-3">
                <h5>Contact Us</h5>
                <p>📍  City Center, Coventry, United Kingdom</p>
                <p>📞 +44 7554809890</p>
                <p>📧 info@incidentreporting.com</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345093743!2d144.95373631590414!3d-37.81627974202198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0x5045675218ce6e0!2sShopping%20Mall!5e0!3m2!1sen!2sus!4v1616161616161!5m2!1sen!2sus" width="100%" height="100" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>

            <!-- Newsletter Subscription -->
            <div class="col-md-3">
                <h5>Subscribe to our Newsletter</h5>
                <form id="subscribeForm">
                    <div class="mb-2">
                        <input type="email" id="emailInput" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Subscribe</button>
                </form>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="row mt-4 border-top pt-3 text-center">
            <div class="col-md-6">
                <p>&copy; 2025 Incident Reporting System. All rights reserved.</p>
            </div>
            <div class="col-md-6">
                <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
                <a href="#" class="text-white text-decoration-none">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap Modal for Success Message -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Subscription Successful</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Thank you for subscribing! You will receive our latest updates in your inbox.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- FontAwesome for social icons -->
<script src="https://kit.fontawesome.com/265c9c0c74.js" crossorigin="anonymous"></script>
<!-- Bootstrap JS for modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



<!-- JavaScript to Show Modal on Form Submission -->
<script>
    document.getElementById("subscribeForm").addEventListener("submit", function(event) {
        event.preventDefault();
        var email = document.getElementById("emailInput").value;
        if (email) {
            var successModal = new bootstrap.Modal(document.getElementById("successModal"));
            successModal.show();
            document.getElementById("subscribeForm").reset();
        }
    });
</script>
