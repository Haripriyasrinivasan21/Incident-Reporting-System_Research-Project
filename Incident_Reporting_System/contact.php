<?php
include 'user_header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Incident Reporting System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="section-title text-center">📞 Contact Us</h2>
    <p class="text-center">Need assistance? Reach out to us using the details below.</p>
    
    <div class="contact-info text-center">
        <h4>Customer Support</h4>
        <p>📞 <strong>Phone:</strong>+44 20 7946 0991 <br>Available from Monday to Friday, 9:00 AM – 5:00 PM BST</p>
        <p>📧 <strong>Email:</strong> support@incidentreporting.com</p>
        <p>💬 <strong>Live Chat:</strong> Available 24/7</p>
        
        <h4>Address</h4>
        <p>🏢 City Center, Coventry, United Kingdom</p>
    </div>

    <div class="map-container my-4">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345093677!2d144.95373531531892!3d-37.81627974202165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf0727c4b9b0174d3!2sShopping+Mall!5e0!3m2!1sen!2s!4v1621234567890!5m2!1sen!2s" 
            width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen>
        </iframe>
    </div>

    <!-- Contact Form -->
    <h4>Contact Form</h4>
    <form id="contactForm" class="needs-validation" novalidate>
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
        </div>
        <div class="mb-3">
            <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">Send Message</button>
    </form>

    <!-- Feedback or Complaint Form -->
        <h4 class="mt-4">Feedback or Complaint Form</h4>
        <form id="feedbackForm" class="needs-validation" novalidate>
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
            </div>
            <div class="mb-3">
                <textarea name="feedback" class="form-control" rows="5" placeholder="Your Feedback or Complaint" required></textarea>
            </div>
            <button type="submit" class="btn btn-warning w-100">Submit Feedback</button>
        </form>

    <!-- Success Message Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="successModalLabel">Message Sent!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Thank you for reaching out! We will get back to you soon.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>

    <h4 class="mt-4">Frequently Asked Questions (FAQs)</h4>
    <div class="faq">
        <div class="faq-item">
            <strong>Q: Who can submit an incident report?</strong>
            <p>A: Any healthcare professional, including clinical staff, support workers, and administrators, can submit reports anonymously through our platform.</p>
        </div>
        <div class="faq-item">
            <strong>Q: Is my identity protected when submitting a report?</strong>
            <p>A: Absolutely! Our system supports anonymous reporting and ensures that personal identifiers are kept confidential.</p>
        </div>
        <div class="faq-item">
            <strong>Q: What types of incidents should be reported?</strong>
            <p>A: You can report anything from adverse events and near misses to unsafe conditions or protocol violations.</p>
        </div>
        <div class="faq-item">
            <strong>Q: Does reporting affect my performance reviews?</strong>
            <p>A: No. Reporting incidents is encouraged as part of a learning culture and has no negative impact on evaluations.</p>
        </div>
        <div class="faq-item">
            <strong>Q: What happens after a report is submitted?</strong>
            <p>A: It is routed to the relevant review team. They assess the incident, tag severity, and initiate follow-up actions where appropriate.</p>
        </div>
        <div class="faq-item">
            <strong>Q: How can I suggest improvements to the IRS?</strong>
            <p>A: You can use the built-in feedback form or contact the support team directly through the Help section.</p>
        </div>
    </div>
</div>

<script>
document.getElementById("contactForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent actual form submission

    // Validate form
    if (this.checkValidity()) {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        this.reset(); // Reset form fields
    } else {
        this.reportValidity(); // Show validation errors
    }
});

document.getElementById("feedbackForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent actual form submission

    // Validate form
    if (this.checkValidity()) {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        this.reset(); // Reset form fields
    } else {
        this.reportValidity(); // Show validation errors
    }
});
</script>

</body>
</html>

<?php
include 'user_footer.php';
?>