<?php
/**
 * Page principale du module Roundcube - VERSION COMPLÈTE AVEC AUTOLOGIN AUTOMATIQUE
 * Conserve toutes les fonctionnalités + connexion automatique au compte par défaut
 * 
 * Emplacement: custom/roundcubemodule/roundcube.php
 */

// Recherche de main.inc.php
$res = 0;
$paths = ['../../main.inc.php', '../../../main.inc.php', '../../../../main.inc.php'];
foreach ($paths as $path) {
    if (file_exists($path)) {
        require $path;
        $res = 1;
        break;
    }
}

if (!$res) {
    die('Erreur: Impossible de trouver main.inc.php. Vérifiez le chemin d\'installation.');
}

// Vérifier la connexion utilisateur
if (empty($user->id)) {
    accessforbidden();
}

// Vérifier les droits d'accès au webmail
if (!$user->hasRight('roundcubemodule', 'webmail', 'read')) {
    accessforbidden('Vous n\'avez pas les droits pour accéder au webmail');
}

// Configuration
$conf->dol_hide_leftmenu = 1;
$langs->load("mails");

// Header
llxHeader('', 'Roundcube Module - Webmail Intégré');

// =====================================
// GESTION AUTOMATIQUE DES COMPTES
// =====================================

// Fonction pour décrypter le mot de passe
function decryptPassword($encryptedPassword) {
    return base64_decode($encryptedPassword);
}

// Récupérer les comptes webmail de l'utilisateur
$sql = "SELECT * FROM ".MAIN_DB_PREFIX."mailboxmodule_webmail_accounts ";
$sql .= "WHERE fk_user = ".$user->id." AND is_active = 1 ";
$sql .= "ORDER BY is_default DESC, account_name ASC";

$resql = $db->query($sql);
$accounts = array();
$default_account = null;

if ($resql) {
    while ($obj = $db->fetch_object($resql)) {
        $accounts[] = $obj;
        if ($obj->is_default || !$default_account) {
            $default_account = $obj;
        }
    }
}

// Si aucun compte configuré, rediriger vers la configuration
if (empty($accounts)) {
    $config_url = dol_buildpath('/user/card.php?id='.$user->id.'&tab=webmail', 1);
    
    print '<div class="center" style="margin-top: 50px;">';
    print '<div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 5px; padding: 20px; max-width: 600px; margin: 0 auto;">';
    print '<h3>📧 Aucun compte webmail configuré</h3>';
    print '<p>Vous devez d\'abord configurer au moins un compte webmail pour accéder à Roundcube.</p>';
    print '<p><a href="'.$config_url.'" class="button">Configurer mes comptes webmail</a></p>';
    print '</div>';
    print '</div>';
    
    llxFooter();
    exit;
}

// =====================================
// CONFIGURATION ROUNDCUBE (conservée)
// =====================================
$roundcube_base_url = '';

if (!empty($conf->global->ROUNDCUBE_URL)) {
    $roundcube_base_url = $conf->global->ROUNDCUBE_URL;
} else {
    $test_path = DOL_DOCUMENT_ROOT . '/custom/roundcubemodule/roundcube/index.php';
    if (file_exists($test_path)) {
        $roundcube_base_url = '/AVOCATS/htdocs/custom/roundcubemodule/roundcube/';
    }
    elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . '/roundcube/index.php')) {
        $roundcube_base_url = '/roundcube/';
    }
    elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . '/roundcubemail/index.php')) {
        $roundcube_base_url = '/roundcubemail/';
    }
    elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . '/webmail/index.php')) {
        $roundcube_base_url = '/webmail/';
    }
    else {
        $roundcube_base_url = '/roundcube/';
    }
}

if (strpos($roundcube_base_url, 'http') !== 0) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    
    if (strpos($roundcube_base_url, '/') !== 0) {
        $roundcube_base_url = '/' . $roundcube_base_url;
    }
    
    $roundcube_base_url = $protocol . $host . $roundcube_base_url;
}

if (substr($roundcube_base_url, -1) !== '/') {
    $roundcube_base_url .= '/';
}

// =====================================
// AUTOLOGIN AVEC LE COMPTE PAR DÉFAUT
// =====================================
// =====================================
// AUTOLOGIN AVEC LE COMPTE PAR DÉFAUT
// =====================================
$roundcube_url = $roundcube_base_url;

$shared_secret = 'MyAx37okNmcBQWxsVIGDW29WDXiiuRkqZVZJQ364oyGFjCDzTvSznzQflQvsYpdW'; // Doit correspondre au secret du plugin
$dolibarr_user_id = $user->id;
$default_account_id = $default_account ? $default_account->rowid : '';

// Construction de la nouvelle URL d'autologin pour la page initiale
$separator = (strpos($roundcube_url, '?') === false) ? '?' : '&';
$roundcube_url = $roundcube_url . $separator .
                '_autologin=1' .
                '&secret=' . urlencode($shared_secret) .
                '&dolibarr_id=' . urlencode($dolibarr_user_id) .
                '&account_id=' . urlencode($default_account_id);

if (!empty($conf->global->ROUNDCUBE_DEBUG)) {
    print '<!-- Roundcube URL: ' . htmlspecialchars($roundcube_url) . ' -->';
}

// =====================================
// INCLUSION DU NOUVEAU BANDEAU (conservé)
// =====================================
require_once DOL_DOCUMENT_ROOT.'/custom/roundcubemodule/components/bandeau/BandeauManager.php';
?>

<!-- Interface de sélection des comptes (si plusieurs comptes) -->
<?php if (count($accounts) > 1): ?>
<div id="account-selector" style="background: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div>
            <strong>📧 Compte actuel :</strong>
            <select id="account-select" onchange="switchAccount()" style="margin-left: 10px; padding: 5px;">
                <?php foreach ($accounts as $account): ?>
                <option value="<?php echo $account->rowid; ?>" 
                        <?php echo ($account->rowid == $default_account->rowid) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($account->email); ?>
                    <?php if ($account->account_name): ?>
                        (<?php echo htmlspecialchars($account->account_name); ?>)
                    <?php endif; ?>
                    <?php if ($account->is_default): ?>
                        - Par défaut
                    <?php endif; ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div>
            <button onclick="refreshRoundcube()" style="margin-right: 10px;">🔄 Actualiser</button>
            <button onclick="openNewWindow()">🗗 Nouvelle fenêtre</button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Container principal -->
<div id="roundcube-container">
    <!-- Message d'erreur si Roundcube ne charge pas -->
    <div id="roundcube-error" style="display:none;">
        <h3 style="color: #e74c3c;">⚠️ Roundcube non accessible</h3>
        <p>L'URL configurée ne répond pas : <br><code><?php echo htmlspecialchars($roundcube_url); ?></code></p>
        <p>Veuillez vérifier la configuration :</p>
        <a href="<?php echo dol_buildpath('/custom/roundcubemodule/admin/roundcube_setup.php', 1); ?>" class="button">
            ⚙️ Configurer l'URL
        </a>
        <br><br>
        <details>
            <summary>Détails techniques</summary>
            <small style="text-align: left; display: block; margin-top: 10px;">
                URL testée : <?php echo htmlspecialchars($roundcube_url); ?><br>
                Serveur : <?php echo $_SERVER['HTTP_HOST']; ?><br>
                Document root : <?php echo $_SERVER['DOCUMENT_ROOT']; ?>
            </small>
        </details>
    </div>
    
    <!-- Iframe Roundcube -->
    <iframe id="roundcube-iframe" 
            src="<?php echo htmlspecialchars($roundcube_url); ?>"
            onerror="handleIframeError()"
            style="width: 100%; height: 100%; border: none;">
    </iframe>
    
    <?php
    // Rendre le bandeau avec la nouvelle architecture (conservé)
    BandeauManager::renderBandeau($user, $conf, $db, $langs, $roundcube_url);
    ?>
</div>

<!-- Script de détection Roundcube (inline pour éviter les erreurs de chargement) - CONSERVÉ -->
<script>
/**
 * Script de détection Roundcube à injecter dans l'iframe - CONSERVÉ INTÉGRALEMENT
 */
function getIframeDetectionScript() {
    return `
(function() {
    console.log('🔍 Script de détection Roundcube activé - Version 2.0');
    
    if (window.roundcubeDetectionActive) {
        console.log('Script déjà actif, skip');
        return;
    }
    window.roundcubeDetectionActive = true;
    
    let currentMailData = null;
    let lastUID = null;
    
    function extractMailData() {
        let mailData = {
            subject: null,
            from: null,
            from_email: null,
            date: null,
            message_id: null,
            uid: null,
            folder: null,
            has_attachments: false,
            is_read: false
        };
        
        try {
            // Extraction via API Roundcube
            if (window.rcmail && window.rcmail.env) {
                console.log('API Roundcube détectée');
                if (window.rcmail.env.uid) {
                    mailData.uid = String(window.rcmail.env.uid);
                    mailData.folder = window.rcmail.env.mailbox || 'INBOX';
                    
                    if (window.rcmail.env.subject) {
                        mailData.subject = window.rcmail.env.subject;
                    }
                    
                    console.log('UID détecté via API:', mailData.uid);
                }
            }
            
            // Extraction via DOM
            const messageHeader = document.querySelector('#messageheader, .message-header, .messageheader, #message-header');
            if (messageHeader) {
                console.log('Header du message trouvé');
                
                const subjectEl = messageHeader.querySelector('.subject, [class*="subject"], #message-subject');
                if (subjectEl) {
                    mailData.subject = subjectEl.textContent.trim();
                }
                
                const fromEl = messageHeader.querySelector('.from, [class*="from"], #message-from');
                if (fromEl) {
                    mailData.from = fromEl.textContent.trim();
                    const emailMatch = mailData.from.match(/<([^>]+)>/) || mailData.from.match(/([^\\s]+@[^\\s]+)/);
                    if (emailMatch) {
                        mailData.from_email = emailMatch[1];
                    }
                }
            }
            
            // Extraction via liste des messages
            const selectedMessage = document.querySelector('.messagelist .selected, #messagelist .selected, tr.selected, .message-list .selected, [id^="rcmrow"].selected');
            if (selectedMessage) {
                console.log('Message sélectionné dans la liste trouvé');
                
                if (selectedMessage.id && !mailData.uid) {
                    const uidMatch = selectedMessage.id.match(/\\d+/);
                    if (uidMatch) {
                        mailData.uid = uidMatch[0];
                    }
                }
                
                if (!mailData.subject) {
                    const subjectCell = selectedMessage.querySelector('.subject, td.subject');
                    if (subjectCell) {
                        mailData.subject = subjectCell.textContent.trim();
                    }
                }
                
                mailData.is_read = !selectedMessage.classList.contains('unread');
                mailData.has_attachments = !!selectedMessage.querySelector('.attachment, .icon.attachment');
            }
            
        } catch (e) {
            console.error('Erreur extraction données mail:', e);
        }
        
        return mailData;
    }
    
    function sendMailData(mailData) {
        if (!mailData.uid && !mailData.subject) {
            return;
        }
        
        if (mailData.uid && mailData.uid === lastUID) {
            return;
        }
        
        lastUID = mailData.uid;
        mailData.timestamp = new Date().toISOString();
        
        console.log('📧 Envoi des données du mail vers le parent:', mailData);
        
        try {
            if (window.parent && window.parent !== window) {
                window.parent.postMessage({
                    type: 'roundcube_mail_selected',
                    data: mailData
                }, '*');
            }
        } catch (e) {
            console.error('Erreur envoi message:', e);
        }
    }
    
    // Observer pour détecter les changements
    const observer = new MutationObserver(() => {
        clearTimeout(window.extractTimeout);
        window.extractTimeout = setTimeout(() => {
            const mailData = extractMailData();
            if (mailData.uid || mailData.subject) {
                sendMailData(mailData);
            }
        }, 300);
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true,
        attributes: true,
        attributeFilter: ['class', 'id']
    });
    
    // Événements de clic
    document.addEventListener('click', function() {
        setTimeout(() => {
            const mailData = extractMailData();
            if (mailData.uid || mailData.subject) {
                sendMailData(mailData);
            }
        }, 500);
    }, true);
    
    // Changements de hash
    window.addEventListener('hashchange', function() {
        setTimeout(() => {
            const mailData = extractMailData();
            if (mailData.uid || mailData.subject) {
                sendMailData(mailData);
            }
        }, 500);
    });
    
    // Vérification périodique
    setInterval(() => {
        const mailData = extractMailData();
        if (mailData.uid || mailData.subject) {
            const dataString = JSON.stringify(mailData);
            if (dataString !== currentMailData) {
                currentMailData = dataString;
                sendMailData(mailData);
            }
        }
    }, 2000);
    
    // Hook sur les commandes Roundcube
    if (window.rcmail && window.rcmail.command_handler) {
        const originalCommand = window.rcmail.command_handler;
        window.rcmail.command_handler = function(command, props, obj, event) {
            const result = originalCommand.apply(this, arguments);
            
            if (command === 'show' || command === 'preview' || command === 'select') {
                setTimeout(() => {
                    const mailData = extractMailData();
                    if (mailData.uid || mailData.subject) {
                        sendMailData(mailData);
                    }
                }, 500);
            }
            
            return result;
        };
    }
    
    // Test initial
    setTimeout(() => {
        const mailData = extractMailData();
        if (mailData.uid || mailData.subject) {
            sendMailData(mailData);
        }
    }, 1000);
    
    console.log('✅ Détection Roundcube initialisée avec succès');
})();
    `;
}

/**
 * Injection du script de détection dans l'iframe - CONSERVÉ
 */
function injectDetectionScript() {
    const iframe = document.getElementById('roundcube-iframe');
    if (!iframe) return;
    
    try {
        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
        
        if (iframeDoc) {
            if (!iframeDoc.getElementById('roundcube-detection-script')) {
                const script = iframeDoc.createElement('script');
                script.id = 'roundcube-detection-script';
                script.textContent = getIframeDetectionScript();
                
                iframeDoc.head.appendChild(script);
                console.log('✅ Script de détection injecté avec succès');
            }
        } else {
            console.warn('⚠️ Impossible d\'accéder au contenu de l\'iframe (cross-origin)');
        }
    } catch (error) {
        console.warn('⚠️ Impossible d\'injecter le script de détection:', error.message);
    }
}

// =====================================
// NOUVELLES FONCTIONS POUR MULTI-COMPTES
// =====================================

// Données des comptes (pour JavaScript)
const accounts = <?php echo json_encode($accounts); ?>;
const roundcubeBaseUrl = "<?php echo $roundcube_base_url; ?>";

/**
 * Fonction pour décrypter le mot de passe côté client
 */
function decryptPassword(encrypted) {
    try {
        return atob(encrypted);
    } catch (e) {
        console.error('Erreur déchiffrement mot de passe:', e);
        return '';
    }
}

/**
 * Changer de compte webmail
 */
function switchAccount() {
    const select = document.getElementById('account-select');
    if (!select) return;
    
    const accountId = select.value;
    
    // Trouver le compte sélectionné
    const account = accounts.find(acc => acc.rowid == accountId);
    
    if (account) {
        console.log('🔄 Changement de compte vers:', account.email);
        
        // 1. Mettre à jour le bandeau avec les infos du nouveau compte
        updateBandeauAccount(account);
        
        // 2. Construire les URLs
        const password = decryptPassword(account.password_encrypted);
        const timestamp = new Date().getTime();
        
        // URL de déconnexion Roundcube (VRAIE déconnexion)
        // Le secret partagé doit être le même que dans le plugin autologon.php
        const sharedSecret = 'MyAx37okNmcBQWxsVIGDW29WDXiiuRkqZVZJQ364oyGFjCDzTvSznzQflQvsYpdW';
        const dolibarrUserId = '<?php echo $user->id; ?>';

        // URL de déconnexion Roundcube (VRAIE déconnexion)
        const logoutUrl = roundcubeBaseUrl + '?_task=logout&_err=session';
        
        // URL de connexion avec le nouveau compte en utilisant l'autologin sécurisé
        const loginUrl = roundcubeBaseUrl + 
                        '?_autologin=1' +
                        '&secret=' + encodeURIComponent(sharedSecret) +
                        '&dolibarr_id=' + encodeURIComponent(dolibarrUserId) +
                        '&account_id=' + encodeURIComponent(account.rowid) +
                        '&_nocache=' + timestamp;
        
        // 3. Afficher un indicateur de chargement
        const iframe = document.getElementById('roundcube-iframe');
        const container = document.getElementById('roundcube-container');
        
        showSwitchProgress(account.email);
        
        // 4. Séquence de déconnexion/reconnexion FORCÉE
        performAccountSwitch(iframe, logoutUrl, loginUrl, account);
    }
}

/**
 * Afficher la progression du changement de compte
 */
function showSwitchProgress(email) {
    const container = document.getElementById('roundcube-container');
    
    // Créer overlay de chargement
    let loadingOverlay = document.getElementById('loading-overlay');
    if (!loadingOverlay) {
        loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'loading-overlay';
        loadingOverlay.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            font-size: 16px;
        `;
        container.appendChild(loadingOverlay);
    }
    
    loadingOverlay.style.display = 'flex';
    loadingOverlay.innerHTML = `
        <div style="text-align: center; max-width: 400px;">
            <div style="font-size: 18px; margin-bottom: 10px;">🔄 Changement de compte</div>
            <div style="margin-bottom: 15px;">
                <strong style="color: #007cba;">${email}</strong>
            </div>
            <div id="switch-step" style="margin-bottom: 15px; color: #666;">
                Initialisation...
            </div>
            <div style="width: 300px; height: 6px; background: #eee; border-radius: 3px; margin: 0 auto;">
                <div id="switch-progress-bar" style="width: 0%; height: 100%; background: linear-gradient(90deg, #007cba, #28a745); border-radius: 3px; transition: width 0.5s ease;"></div>
            </div>
            <div style="margin-top: 10px; font-size: 12px; color: #999;">
                Déconnexion puis reconnexion en cours...
            </div>
        </div>
    `;
}

/**
 * Mettre à jour l'étape et la progression
 */
function updateSwitchProgress(percent, step) {
    const progressBar = document.getElementById('switch-progress-bar');
    const stepEl = document.getElementById('switch-step');
    
    if (progressBar) progressBar.style.width = percent + '%';
    if (stepEl) stepEl.textContent = step;
}

/**
 * Masquer la progression
 */
function hideSwitchProgress() {
    const loadingOverlay = document.getElementById('loading-overlay');
    if (loadingOverlay) {
        // Animation de fade out
        loadingOverlay.style.transition = 'opacity 0.5s ease';
        loadingOverlay.style.opacity = '0';
        setTimeout(() => {
            loadingOverlay.style.display = 'none';
            loadingOverlay.style.opacity = '1';
        }, 500);
    }
}

/**
 * Effectuer le changement de compte avec déconnexion/reconnexion forcée
 */
/**
 * Effectue le changement de compte avec une séquence de déconnexion/reconnexion fiable.
 */
/**
 * Effectue le changement de compte avec une séquence de déconnexion/reconnexion fiable via une requête POST.
 */
function performAccountSwitch(iframe, logoutUrl, loginUrl, account) {
    updateSwitchProgress(10, 'Déconnexion du compte actuel...');

    // Timeout de sécurité global
    const safetyTimeout = setTimeout(() => {
        console.error('❌ Timeout lors du changement de compte');
        hideSwitchProgress();
        alert('Le changement de compte a pris trop de temps. Veuillez actualiser la page.');
    }, 15000);

    // Fonction pour gérer la connexion
    const handleLogin = () => {
        updateSwitchProgress(50, 'Déconnecté. Connexion au nouveau compte...');
        iframe.src = loginUrl;

        // Gérer le succès ou l'échec de la connexion
        iframe.onload = () => {
            updateSwitchProgress(100, 'Connexion réussie!');
            hideSwitchProgress();
            updateBandeauAccount(account);
            setTimeout(injectDetectionScript, 2000);
            console.log('🎉 Changement de compte terminé avec succès');
            clearTimeout(safetyTimeout);
        };

        iframe.onerror = () => {
            console.error('❌ Erreur lors de la connexion');
            hideSwitchProgress();
            alert('Erreur lors de la connexion au nouveau compte');
            clearTimeout(safetyTimeout);
        };
    };

    // Créer un formulaire pour faire une requête POST
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = logoutUrl.split('?')[0]; // Utiliser l'URL de base sans le query string
    form.target = iframe.name; // Cible l'iframe par son nom

    // Ajouter les champs cachés nécessaires pour le plugin autologout
    const fields = {
        _action: 'logout',
        _task: 'logout',
        _autologout: '1'
    };

    for (const key in fields) {
        if (fields.hasOwnProperty(key)) {
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = key;
            hiddenField.value = fields[key];
            form.appendChild(hiddenField);
        }
    }

    // Ajouter le formulaire au corps du document pour le soumettre
    document.body.appendChild(form);

    // Attendre que la déconnexion soit terminée
    iframe.onload = () => {
        // La déconnexion a eu lieu, on peut passer à la connexion
        handleLogin();
    };

    // En cas d'erreur de chargement de la déconnexion, on essaie quand même de se connecter
    iframe.onerror = () => {
        console.warn('⚠️ Erreur de déconnexion, tentative de connexion directe...');
        handleLogin();
    };

    // Soumettre le formulaire, ce qui déclenchera la déconnexion POST
    form.submit();

    // Supprimer le formulaire une fois soumis
    form.remove();
}

/**
 * Mettre à jour les informations du bandeau avec le nouveau compte
 */
function updateBandeauAccount(account) {
    // Mettre à jour les éléments du bandeau si ils existent
    const bandeauEmail = document.querySelector('#bandeau-current-email, .bandeau-email');
    const bandeauAccount = document.querySelector('#bandeau-current-account, .bandeau-account');
    
    if (bandeauEmail) {
        bandeauEmail.textContent = account.email;
    }
    
    if (bandeauAccount) {
        bandeauAccount.textContent = account.account_name || account.email;
    }
    
    // Mettre à jour le titre de la page
    document.title = `Roundcube - ${account.email}`;
    
    console.log('📧 Bandeau mis à jour pour le compte:', account.email);
}

/**
 * Notifier le changement de compte au bandeau (via postMessage)
 */
function notifyAccountChange(account) {
    // Envoyer un message au bandeau pour l'informer du changement
    if (window.parent && window.parent !== window) {
        window.parent.postMessage({
            type: 'account_changed',
            data: {
                accountId: account.rowid,
                email: account.email,
                accountName: account.account_name,
                imapHost: account.imap_host,
                isDefault: account.is_default
            }
        }, '*');
    }
    
    // Déclencher un événement personnalisé pour d'autres composants
    const event = new CustomEvent('roundcubeAccountChanged', {
        detail: account
    });
    document.dispatchEvent(event);
    
    console.log('📨 Notification changement de compte envoyée');
}

/**
 * Actualiser Roundcube
 */
function refreshRoundcube() {
    const iframe = document.getElementById('roundcube-iframe');
    iframe.src = iframe.src;
    console.log('🔄 Actualisation de Roundcube');
}

/**
 * Ouvrir dans une nouvelle fenêtre
 */
function openNewWindow() {
    const iframe = document.getElementById('roundcube-iframe');
    window.open(iframe.src, 'roundcube', 'width=1200,height=800,scrollbars=yes,resizable=yes');
}

/**
 * Gérer les erreurs d'iframe
 */
function handleIframeError() {
    document.getElementById('roundcube-error').style.display = 'block';
    document.getElementById('roundcube-iframe').style.display = 'none';
}

/**
 * Initialisation de la page - CONSERVÉ + AMÉLIORÉ
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Roundcube Module - Version complète avec autologin chargée');
    console.log('📧 Comptes disponibles:', accounts.length);
    
    const iframe = document.getElementById('roundcube-iframe');
    
    // Injection du script à chaque chargement de l'iframe - CONSERVÉ
    iframe.onload = function() {
        console.log('Iframe Roundcube chargée');
        setTimeout(injectDetectionScript, 2000);
    };
    
    // Gestion des erreurs
    iframe.onerror = function() {
        console.error('❌ Erreur de chargement Roundcube');
        handleIframeError();
    };
    
    // Réinjection périodique - CONSERVÉ
    setInterval(function() {
        if (iframe.contentDocument || iframe.contentWindow) {
            injectDetectionScript();
        }
    }, 5000);
    
    // Écouter les messages du bandeau ou d'autres composants
    window.addEventListener('message', function(event) {
        if (event.data && event.data.type) {
            switch (event.data.type) {
                case 'bandeau_account_change_request':
                    // Le bandeau demande un changement de compte
                    const requestedAccountId = event.data.accountId;
                    const select = document.getElementById('account-select');
                    if (select && requestedAccountId) {
                        select.value = requestedAccountId;
                        switchAccount();
                    }
                    break;
                    
                case 'roundcube_ready':
                    // Roundcube est prêt, envoyer les infos du compte actuel
                    const currentSelect = document.getElementById('account-select');
                    if (currentSelect) {
                        const currentAccountId = currentSelect.value;
                        const currentAccount = accounts.find(acc => acc.rowid == currentAccountId);
                        if (currentAccount) {
                            notifyAccountChange(currentAccount);
                        }
                    }
                    break;
            }
        }
    });
    
    // Initialiser avec le compte par défaut
    setTimeout(() => {
        const select = document.getElementById('account-select');
        if (select) {
            const defaultAccountId = select.value;
            const defaultAccount = accounts.find(acc => acc.rowid == defaultAccountId);
            if (defaultAccount) {
                updateBandeauAccount(defaultAccount);
            }
        }
    }, 1000);
    
    console.log('✅ Module Roundcube complet initialisé');
});

// Styles CSS additionnels
const style = document.createElement('style');
style.textContent = `
    #account-selector {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    #account-selector select {
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
    }
    
    #account-selector button {
        background: #007cba;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
    }
    
    #account-selector button:hover {
        background: #005a87;
    }
    
    #roundcube-container {
        position: relative;
    }
    
    #loading-overlay {
        text-align: center;
        color: #007cba;
        font-weight: bold;
    }
    
    #loading-overlay small {
        color: #666;
        font-weight: normal;
    }
    
    #roundcube-error {
        text-align: center;
        padding: 50px;
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        margin: 20px;
    }
`;
document.head.appendChild(style);
</script>

<?php
llxFooter();
?>

<?php
/*
=====================================
GUIDE DE MIGRATION - CONSERVÉ
=====================================

1. CRÉER LA STRUCTURE DE DOSSIERS :
   custom/roundcubemodule/components/
   ├── bandeau/
   │   ├── BandeauManager.php
   │   ├── css/bandeau.css
   │   └── js/bandeau.js
   └── classification/
       ├── js/mail-classification.js
       └── api/search-entities.php

2. COPIER LES FICHIERS :
   - Copier le CSS dans bandeau.css
   - Copier le JavaScript dans bandeau.js
   - Créer BandeauManager.php avec le code fourni

3. TESTER :
   - Accéder à roundcube-new.php
   - Vérifier que le bandeau s'affiche
   - Tester les fonctionnalités

4. BASCULER :
   - Renommer roundcube.php en roundcube-old.php
   - Renommer roundcube-new.php en roundcube.php

5. NETTOYER :
   - Supprimer roundcube-old.php une fois validé

AVANTAGES DE CETTE ARCHITECTURE :
✅ Code plus maintenable
✅ Séparation des responsabilités
✅ Facilité de débogage
✅ Réutilisabilité des composants
✅ Évolutivité simplifiée

NOUVELLES FONCTIONNALITÉS AJOUTÉES :
✅ Autologin automatique avec les comptes webmail
✅ Sélecteur de comptes multiples
✅ Connexion sans saisie de mot de passe
✅ Fallback sur l'ancienne méthode
✅ Interface utilisateur améliorée
*/
?>