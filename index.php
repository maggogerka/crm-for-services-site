<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$formErrors = flash('form_errors') ?? [];
$formSuccess = flash('form_success');
$oldInput = $_SESSION['_old_input'] ?? [];
$pageTitle = $content['meta']['title'];
$pageDescription = $content['meta']['description'];
$canonicalPath = '';
require ROOT_PATH . '/partials/header.php';
?>
<header class="site-header" data-header>
    <div class="container header-inner">
        <a class="brand" href="#top" aria-label="CRM for services — наверх">
            <img src="assets/images/logo-96.webp" width="48" height="48" alt="" fetchpriority="high">
            <span>CRM <i>for services</i></span>
        </a>
        <button class="menu-button" type="button" aria-expanded="false" aria-controls="site-nav" data-menu-button>
            <span></span><span></span><span></span><span class="sr-only">Открыть меню</span>
        </button>
        <nav class="site-nav" id="site-nav" aria-label="Основная навигация" data-menu>
            <a href="#how">Как работает</a>
            <a href="#features">Возможности</a>
            <a href="#price">Цена</a>
            <a href="#faq">Вопросы</a>
            <a class="button button--small" href="#request">Получить бота</a>
        </nav>
    </div>
</header>

<main id="main">
    <section class="hero" id="top">
        <div class="hero-glow hero-glow--one"></div>
        <div class="hero-glow hero-glow--two"></div>
        <div class="container hero-grid">
            <div class="hero-copy reveal">
                <p class="eyebrow"><span></span><?= e($content['hero']['eyebrow']) ?></p>
                <h1><?= e($content['hero']['title']) ?></h1>
                <p class="hero-text"><?= e($content['hero']['text']) ?></p>
                <div class="hero-actions">
                    <a class="button" href="<?= e($content['links']['demo_bot']) ?>" target="_blank" rel="noopener noreferrer">Попробовать бесплатно <span aria-hidden="true">↗</span></a>
                    <a class="text-link" href="#how">Посмотреть, как работает <span aria-hidden="true">↓</span></a>
                </div>
                <ul class="hero-points" aria-label="Ключевые преимущества">
                    <li><span>✓</span> Без нового приложения</li>
                    <li><span>✓</span> Настройка под вас</li>
                    <li><span>✓</span> Первый месяц включён</li>
                </ul>
            </div>
            <div class="hero-visual reveal reveal--delay">
                <div class="orbit orbit--one"></div><div class="orbit orbit--two"></div>
                <div class="phone phone--hero">
                    <div class="phone-top"><span>9:41</span><b>Telegram</b><span>● ●</span></div>
                    <div class="phone-chat-title">
                        <img src="assets/images/logo-96.webp" alt="" width="36" height="36">
                        <div><b>CRM бот для мастеров</b><small>бот</small></div>
                    </div>
                    <picture>
                        <source srcset="assets/images/screens/booking-date-480.webp 480w, assets/images/screens/booking-date-720.webp 720w" type="image/webp" sizes="(max-width: 600px) 78vw, 390px">
                        <img src="media/IMG_7221.PNG" width="1284" height="2778" alt="Клиент выбирает свободную дату записи в Telegram-боте" fetchpriority="high">
                    </picture>
                </div>
                <div class="float-card float-card--top"><span>✦</span><b>Свободные окна</b><small>показываются автоматически</small></div>
                <div class="float-card float-card--bottom"><span>✓</span><b>Новая запись</b><small>сразу у мастера</small></div>
            </div>
        </div>
    </section>

    <section class="ticker" aria-label="Возможности кратко">
        <div class="ticker-track">
            <span>Онлайн-запись</span><i>✦</i><span>Расписание</span><i>✦</i><span>Клиенты</span><i>✦</i><span>Напоминания</span><i>✦</i><span>Переносы</span><i>✦</i><span>Онлайн-запись</span><i>✦</i><span>Расписание</span>
        </div>
    </section>

    <section class="section problems" id="problems">
        <div class="container">
            <div class="section-heading reveal">
                <p class="eyebrow"><span></span>Знакомая ситуация?</p>
                <h2>Ручная запись забирает больше времени, чем кажется</h2>
                <p>Каждое сообщение — маленькая задача, которая отвлекает от клиентов и копится к концу дня.</p>
            </div>
            <div class="problem-grid">
                <?php foreach ($content['problems'] as $index => $problem): ?>
                    <article class="problem-card reveal">
                        <span class="problem-number">0<?= $index + 1 ?></span>
                        <div class="problem-icon" aria-hidden="true"><?= ['…', '↻', '?!'][$index] ?></div>
                        <h3><?= e($problem['title']) ?></h3>
                        <p><?= e($problem['text']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section process" id="how">
        <div class="container">
            <div class="section-heading section-heading--center reveal">
                <p class="eyebrow"><span></span>Просто для клиента</p>
                <h2>От выбора услуги до записи — несколько понятных шагов</h2>
            </div>
            <div class="process-layout">
                <div class="phone phone--process reveal">
                    <div class="phone-top"><span>9:41</span><b>Telegram</b><span>● ●</span></div>
                    <picture>
                        <source srcset="assets/images/screens/booking-confirm-480.webp 480w, assets/images/screens/booking-confirm-720.webp 720w" type="image/webp" sizes="(max-width: 700px) 80vw, 370px">
                        <img src="media/IMG_7224.PNG" width="1284" height="2778" alt="Экран подтверждения записи клиента в Telegram-боте" loading="lazy">
                    </picture>
                </div>
                <ol class="step-list">
                    <?php foreach ($content['booking_steps'] as $step): ?>
                        <li class="step reveal">
                            <span><?= e($step['number']) ?></span>
                            <div><h3><?= e($step['title']) ?></h3><p><?= e($step['text']) ?></p></div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </section>

    <section class="section features" id="features">
        <div class="container">
            <div class="section-heading reveal">
                <p class="eyebrow"><span></span>Рабочее место в Telegram</p>
                <h2>Всё, что нужно мастеру для ежедневной работы</h2>
            </div>
            <div class="feature-grid">
                <?php $symbols = ['calendar'=>'▦','users'=>'♙','check'=>'✓','refresh'=>'↻','bell'=>'◉','tools'=>'⌁','settings'=>'⚙','team'=>'♟']; ?>
                <?php foreach ($content['features'] as $feature): ?>
                    <article class="feature-card reveal">
                        <span class="feature-icon" aria-hidden="true"><?= $symbols[$feature['icon']] ?></span>
                        <h3><?= e($feature['title']) ?></h3>
                        <p><?= e($feature['text']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="feature-showcase reveal">
                <div class="showcase-copy">
                    <span class="pill">Меню мастера</span>
                    <h3>Управляйте визитами там, где уже общаетесь</h3>
                    <p>Откройте запись, подтвердите визит, перенесите или отмените его. Данные клиента и история изменений остаются рядом.</p>
                    <a class="text-link" href="<?= e($content['links']['demo_bot']) ?>" target="_blank" rel="noopener noreferrer">Открыть демобота <span>↗</span></a>
                </div>
                <div class="telegram-window">
                    <div class="telegram-bar"><span>‹</span><div><b>CRM бот для мастеров</b><small>бот</small></div><span>•••</span></div>
                    <picture>
                        <source srcset="assets/images/screens/master-visit-480.webp 480w, assets/images/screens/master-visit-720.webp 720w" type="image/webp" sizes="(max-width: 720px) 88vw, 520px">
                        <img src="media/IMG_7230.PNG" width="1284" height="2778" alt="Карточка визита с быстрыми действиями для мастера" loading="lazy">
                    </picture>
                </div>
            </div>
        </div>
    </section>

    <section class="section custom">
        <div class="container custom-card reveal">
            <div>
                <p class="eyebrow eyebrow--light"><span></span>Не шаблонный сервис</p>
                <h2>Бот под ваш бизнес, а не ваш бизнес под бота</h2>
                <p>Настроим логику записи под реальные процессы: услуги и дополнения, графики сотрудников, предоплату, напоминания, правила переноса и фирменный стиль.</p>
                <a class="button button--light" href="#request">Обсудить настройку <span>→</span></a>
            </div>
            <div class="custom-tags" aria-label="Настраиваемые параметры">
                <span>Ваши услуги</span><span>Ваше расписание</span><span>Ваши сотрудники</span><span>Ваши правила</span><span>Ваш стиль</span>
            </div>
        </div>
    </section>

    <section class="section gallery-section" id="gallery">
        <div class="container">
            <div class="section-heading gallery-heading reveal">
                <div><p class="eyebrow"><span></span>Посмотрите ближе</p><h2>Как бот помогает каждый день</h2></div>
                <div class="gallery-controls" aria-label="Управление галереей"><button type="button" data-gallery-prev aria-label="Назад">←</button><button type="button" data-gallery-next aria-label="Вперёд">→</button></div>
            </div>
            <div class="card-gallery" data-gallery tabindex="0" aria-label="Презентационные карточки CRM for services">
                <?php $cardAlts = ['Онлайн-запись без постоянной переписки','Проблемы ручной записи','Шаги самостоятельной записи клиента','Уведомление мастера о новой записи','База клиентов и история работы','Управление визитом','Возможности меню мастера','Условия настройки и демонстрации']; ?>
                <?php for ($i = 1; $i <= 8; $i++): ?>
                    <figure class="gallery-card">
                        <picture>
                            <source srcset="assets/images/cards/crm-card-<?= $i ?>-540.webp 540w, assets/images/cards/crm-card-<?= $i ?>-900.webp 900w" type="image/webp" sizes="(max-width: 700px) 82vw, 360px">
                            <img src="media/CRM_card <?= $i ?>.png" width="1080" height="1350" alt="<?= e($cardAlts[$i - 1]) ?>" loading="lazy">
                        </picture>
                    </figure>
                <?php endfor; ?>
            </div>
            <p class="swipe-hint">Листайте, чтобы увидеть больше <span aria-hidden="true">→</span></p>
        </div>
    </section>

    <section class="section demo" id="demo">
        <div class="container demo-card reveal">
            <div class="demo-badge">Бесплатно</div>
            <div class="demo-copy">
                <p class="eyebrow"><span></span>Сначала попробуйте</p>
                <h2>Откройте демонстрационного бота</h2>
                <p>Пройдите запись как клиент и загляните в управление мастера. Это <strong>тестовый бот для знакомства</strong>, а не бесплатный полноценный бот для вашего бизнеса.</p>
                <a class="button" href="<?= e($content['links']['demo_bot']) ?>" target="_blank" rel="noopener noreferrer">Попробовать бесплатно <span>↗</span></a>
            </div>
            <div class="demo-chat" aria-label="Пример приветствия демобота">
                <div class="demo-chat-head"><img src="assets/images/logo-96.webp" alt="" width="42" height="42"><div><b>Тестовый бот</b><small>бот</small></div></div>
                <div class="bubble">👋 Привет! Это тестовый бот. Пройдите запись как клиент и посмотрите управление мастера.</div>
                <button type="button" tabindex="-1">🗓 Записаться</button><button type="button" tabindex="-1">👤 Войти как мастер</button>
            </div>
        </div>
    </section>

    <section class="section pricing" id="price">
        <div class="container pricing-grid">
            <div class="section-heading reveal">
                <p class="eyebrow"><span></span>Простая цена</p>
                <h2>Запустите онлайн-запись без большой подписки</h2>
                <p>Сначала создаём и настраиваем персонального бота. Затем вы оплачиваете только сервер и обслуживание.</p>
            </div>
            <div class="price-card reveal">
                <span class="price-label">Создание и настройка</span>
                <div class="price"><b><?= money($content['pricing']['setup']) ?></b><span><?= e($content['pricing']['currency']) ?></span></div>
                <p><?= e($content['pricing']['first_month']) ?></p>
                <hr>
                <div class="monthly"><div><span>Со второго месяца</span><small>Сервер и обслуживание</small></div><b><?= money($content['pricing']['monthly']) ?> <?= e($content['pricing']['currency']) ?><em>/мес.</em></b></div>
                <ul><li>Персональная настройка</li><li>Запуск и проверка сценариев</li><li>Техническая поддержка</li></ul>
                <a class="button button--wide" href="#request">Получить своего бота <span>→</span></a>
            </div>
        </div>
    </section>

    <section class="section launch" id="launch">
        <div class="container">
            <div class="section-heading section-heading--center reveal"><p class="eyebrow"><span></span>Путь к запуску</p><h2>От знакомства до работающей записи</h2></div>
            <ol class="launch-grid">
                <?php foreach ($content['launch_steps'] as $index => $step): ?>
                    <li class="launch-step reveal"><span><?= $index + 1 ?></span><h3><?= e($step['title']) ?></h3><p><?= e($step['text']) ?></p></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <section class="section trust">
        <div class="container">
            <div class="trust-intro reveal"><p class="eyebrow"><span></span>Без громких обещаний</p><h2>Понятный продукт и честный старт</h2><p>Показываем работающий интерфейс и заранее фиксируем, что входит в настройку.</p></div>
            <div class="trust-grid">
                <?php foreach ($content['trust'] as $index => $item): ?><article class="trust-item reveal"><span><?= ['◎','◇','↗'][$index] ?></span><h3><?= e($item['title']) ?></h3><p><?= e($item['text']) ?></p></article><?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section faq" id="faq">
        <div class="container faq-grid">
            <div class="section-heading reveal"><p class="eyebrow"><span></span>Частые вопросы</p><h2>Коротко о главном</h2><p>Если ответа нет, напишите разработчику — обсудим ваш сценарий.</p><a class="text-link" href="<?= e($content['links']['developer']) ?>" target="_blank" rel="noopener noreferrer">Написать разработчику <span>↗</span></a></div>
            <div class="accordion">
                <?php foreach ($content['faq'] as $index => $item): ?>
                    <details class="faq-item reveal"<?= $index === 0 ? ' open' : '' ?>><summary><?= e($item['question']) ?><span>+</span></summary><p><?= e($item['answer']) ?></p></details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section request" id="request">
        <div class="container request-card">
            <div class="request-copy reveal">
                <p class="eyebrow eyebrow--light"><span></span>Давайте познакомимся</p>
                <h2>Расскажите о своей записи</h2>
                <p>Ответим, подойдёт ли бот вашему бизнесу, и предложим следующий шаг. Заявка ни к чему не обязывает.</p>
                <div class="request-contact"><span>Или сразу в Telegram</span><a href="<?= e($content['links']['developer']) ?>" target="_blank" rel="noopener noreferrer"><?= e($content['contacts']['telegram']) ?> ↗</a></div>
            </div>
            <form class="lead-form reveal" action="submit-lead.php" method="post" novalidate data-lead-form>
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <div class="honeypot" aria-hidden="true"><label>Ваш сайт<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
                <?php if ($formSuccess): ?><div class="form-alert form-alert--success" role="status"><?= e($formSuccess) ?></div><?php endif; ?>
                <?php if (!empty($formErrors['form'])): ?>
                    <div class="form-alert form-alert--error" role="alert"><?= e($formErrors['form']) ?></div>
                <?php elseif ($formErrors): ?>
                    <div class="form-alert form-alert--error" role="alert">Проверьте отмеченные поля и отправьте форму ещё раз.</div>
                <?php endif; ?>
                <div class="form-row">
                    <label>Как вас зовут? <input type="text" name="name" value="<?= e($oldInput['name'] ?? '') ?>" maxlength="80" autocomplete="name" required aria-describedby="name-error"><small id="name-error"><?= e($formErrors['name'] ?? '') ?></small></label>
                    <label>Чем вы занимаетесь? <input type="text" name="direction" value="<?= e($oldInput['direction'] ?? '') ?>" maxlength="120" placeholder="Например, маникюр" required aria-describedby="direction-error"><small id="direction-error"><?= e($formErrors['direction'] ?? '') ?></small></label>
                </div>
                <label>Telegram или телефон <input type="text" name="contact" value="<?= e($oldInput['contact'] ?? '') ?>" maxlength="120" placeholder="@username или +7 999 000-00-00" autocomplete="tel" required aria-describedby="contact-error"><small id="contact-error"><?= e($formErrors['contact'] ?? '') ?></small></label>
                <div class="form-row">
                    <label>Формат работы <select name="work_format" required><option value="solo"<?= (($oldInput['work_format'] ?? '') === 'solo') ? ' selected' : '' ?>>Один мастер</option><option value="team"<?= (($oldInput['work_format'] ?? '') === 'team') ? ' selected' : '' ?>>Команда</option></select></label>
                    <label>Как лучше связаться? <select name="preferred_contact" required><option value="telegram"<?= (($oldInput['preferred_contact'] ?? '') === 'telegram') ? ' selected' : '' ?>>Telegram</option><option value="phone"<?= (($oldInput['preferred_contact'] ?? '') === 'phone') ? ' selected' : '' ?>>Телефон</option></select></label>
                </div>
                <label>Комментарий <textarea name="comment" rows="4" maxlength="1000" placeholder="Что важно учесть?" aria-describedby="comment-error"><?= e($oldInput['comment'] ?? '') ?></textarea><small id="comment-error"><?= e($formErrors['comment'] ?? '') ?></small></label>
                <label class="check-field"><input type="checkbox" name="consent" value="1"<?= !empty($oldInput['consent']) ? ' checked' : '' ?> required><span>Я согласен(на) на <a href="consent.php" target="_blank">обработку персональных данных</a></span></label>
                <?php if (!empty($formErrors['consent'])): ?><small class="standalone-error"><?= e($formErrors['consent']) ?></small><?php endif; ?>
                <button class="button button--wide button--light" type="submit">Отправить заявку <span>→</span></button>
                <p class="form-note">Ответим в выбранном канале связи.</p>
            </form>
        </div>
    </section>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => $content['brand'],
    'description' => $content['meta']['description'],
    'provider' => ['@type' => 'Organization', 'name' => $content['brand'], 'url' => url()],
    'areaServed' => 'RU',
    'offers' => ['@type' => 'Offer', 'price' => $content['pricing']['setup'], 'priceCurrency' => 'RUB', 'availability' => 'https://schema.org/InStock'],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
<?php clear_old_input(); require ROOT_PATH . '/partials/footer.php'; ?>
