<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * Base Site URL
     */
    public string $baseURL = 'http://localhost/paulisexto/TESINA26/codeigniter-1/public/';

    /**
     * Allowed Hostnames
     */
    public array $allowedHostnames = [];

    /**
     * Index File
     * IMPORTANTE: vacío si usás /public/
     */
    public string $indexPage = '';

    /**
     * URI Protocol
     */
    public string $uriProtocol = 'REQUEST_URI';

    /**
     * Allowed URL Characters
     */
    public string $permittedURIChars = 'a-z 0-9~%.:_\-';

    /**
     * Default Locale
     */
    public string $defaultLocale = 'en';

    /**
     * Negotiate Locale
     */
    public bool $negotiateLocale = false;

    /**
     * Supported Locales
     */
    public array $supportedLocales = ['en'];

    /**
     * Timezone
     */
    public string $appTimezone = 'UTC';

    /**
     * Charset
     */
    public string $charset = 'UTF-8';

    /**
     * Force HTTPS
     */
    public bool $forceGlobalSecureRequests = false;

    /**
     * Proxy IPs
     */
    public array $proxyIPs = [];

    /**
     * CSP
     */
    public bool $CSPEnabled = false;
}