<!-- Contact information and the database-backed message form. -->
<section class="content-section contact-section" id="contact">
    <div class="section-index">05 <span>—</span> SAY HELLO</div>
    <div class="contact-layout">
        <div class="contact-copy">
            <p class="eyebrow">LET'S MAKE SOMETHING SPECIAL</p>
            <h2>Have an idea<br>in <em>mind?</em></h2>
            <p>Ask about a product, request a custom piece, or just send a little hello. I’d love to hear from you.</p>
            <div class="contact-detail"><span>EMAIL</span><a href="mailto:nicxyy.9@gmail.com">nicxyy.9@gmail.com</a></div>
            <div class="contact-detail"><span>RESPONSE TIME</span><strong>Usually within 1–2 days</strong></div>
        </div>
        <form class="contact-form" action="index.php#contact" method="post">
            <?php if (!empty($contactFeedback)): ?>
                <div class="alert alert-info" role="status"><?= htmlspecialchars($contactFeedback, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            <div class="form-row"><label for="name">Your Name</label><input id="name" name="name" type="text" maxlength="120" autocomplete="name" placeholder="How should I address you?" required></div>
            <div class="form-row"><label for="email">Email Address</label><input id="email" name="email" type="email" maxlength="190" autocomplete="email" placeholder="you@example.com" required></div>
            <div class="form-row"><label for="subject">What are you writing about?</label><input id="subject" name="subject" type="text" maxlength="180" placeholder="An order you like, a custom order, a question..." required></div>
            <div class="form-row"><label for="message">Your message</label><textarea id="message" name="message" rows="4" maxlength="5000" placeholder="Tell me a little more..." required></textarea></div>
            <button class="button-main submit-button" type="submit">Send your message <span aria-hidden="true">↗</span></button>
            <p class="form-note">Your message is saved so I can get back to you.</p>
        </form>
    </div>
</section>