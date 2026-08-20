<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <a class="brand brand--footer" href="index.php" aria-label="CRM for services — на главную">
                <img src="assets/images/logo-96.webp" width="48" height="48" alt="" loading="lazy">
                <span>CRM <i>for services</i></span>
            </a>
            <p class="footer-note">Персональная онлайн-запись в Telegram для мастеров и небольших студий.</p>
        </div>
        <div>
            <p class="footer-title">Связаться</p>
            <a href="<?= e($content['links']['developer']) ?>" target="_blank" rel="noopener noreferrer"><?= e($content['contacts']['telegram']) ?></a>
            <a href="mailto:<?= e($content['contacts']['email']) ?>"><?= e($content['contacts']['email']) ?></a>
        </div>
        <div>
            <p class="footer-title">Документы</p>
            <a href="privacy.php">Политика конфиденциальности</a>
            <a href="consent.php">Согласие на обработку данных</a>
            <a href="terms.php">Условия использования</a>
        </div>
    </div>
    <div class="container footer-bottom">
        <span>© <?= date('Y') ?> <?= e($content['brand']) ?></span>
        <span>Работает в Telegram</span>
    </div>
</footer>
<script src="assets/js/app.js?v=1.0.0" defer></script>
</body>
</html>

