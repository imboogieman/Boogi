<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo Yii::app()->params['googleApiKey']; ?>&libraries=places,geometry"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/library/mapoptions.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/library/metadata.js"></script>

<?php if (Yii::app()->params['isDebug']): ?>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/library/markerwithlabel.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/library/markerclusterer.js"></script>
<?php else: ?>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/library/markerwithlabel.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/library/markerclusterer.min.js"></script>
<?php endif; ?>

<div id="loader">
    <div><div></div></div>
</div>

<div id="overlay" class="hidden">
    <div class="mask"></div>
    <div class="rounded shadow block">
        <a class="close-button" href="#close"></a>
        <div class="content"></div>
        <div class="login hidden">
            <div class="row">
                <label for="email">Email</label><br />
                <input type="text" id="email-overlay" name="email-overlay" class="input" value="" />
                <span class="error" data-id="email-overlay"></span>
            </div>

            <div class="row">
                <label for="password">Password</label><br />
                <input type="password" id="password-overlay" name="password-overlay" class="input" value="" />
                <span class="error" data-id="password-overlay"></span>
            </div>

            <div class="row buttons">
                <input type="button" id="login-overlay" name="login-overlay" class="button" value="Let Me In" />
                <a href="/user/signup" id="show-register-form">Sign Up</a>
            </div>

            <div class="row help-spacer">
                <div class="help-spacer-left"></div>need help ?<div class="help-spacer-right"></div>
            </div>

            <div class="row buttons">
                <a href="/user/restore" id="show-restore-form">Restore password</a>
            </div>
        </div>
    </div>
</div>

<div id="menu-block"></div>

<?php
    // Include all Handlebar templates
    try {
        clearstatcache();
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(DOC_ROOT . '/templates/', RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($iterator as $path) {
            if ($path->isFile()) {
                include $path->getPathname();
            }
        }
    } catch (Exception $e) {
        Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'frontapp.templates');
    }