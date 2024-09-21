## prerequisites for email config

- config mail server in .Env
- run queue work command to watch queue
- install supervisor to keep running queue:work

- http://bank-legal-soft.terreorigine-immo.com

## MANAGE SUPERVISOR

-  sudo apt update
- sudo apt install supervisor
- sudo systemctl status supervisor
- cd /etc/supervisor/conf.d/
- sudo nano laravel-queue.conf

 `
[program:laravel-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/bls/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=raoul
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/jobs.out.log
stopwaitsecs=3600
startsecs=0
 `
- sudo supervisorctl reread
- sudo supervisorctl update
- sudo supervisorctl start laravel-queue:*

## Config LDAP
- sudo apt install php-ldap
- composer require directorytree/ldaprecord-laravel
- set up auth mode in .env AUTH_MODE=ldap or AUTH_MODE=database
- set env params
- php artisan ldap:test <!-- to test if set succesfully -->
- php artisan ldap:import users <!-- import AD users -->

* reference <!-- https://anqorithm.medium.com/implementing-ldap-authentication-integration-in-laravel-a-guide-to-using-openldap-phpldapadmin-f34a37e401bd -->


## TEST EMAIL SENDING

* php artisan tinker
* Mail::raw('Hello World!', function($msg) {$msg->to('raoulgbadou@gmail.com')->subject('Test Email'); });


## to do 


* manage permission **
* general settings
* translation in the system
* gestion des alertes
* token expiration management

```
INSERT INTO `litigation_settings` (`id`, `type`, `name`, `description`, `created_at`, `updated_at`, `default`, `created_by`) VALUES
('9d0fbe65-31c2-47a8-9b36-3d2fd5eeb423', 'party_type', 'client', NULL, '2024-09-21 09:04:03', '2024-09-21 09:04:03', 1, NULL),
('9d0fbe65-348d-4ef2-9b8b-0a9b9fa9f813', 'party_type', 'employee', NULL, '2024-09-21 09:04:03', '2024-09-21 09:04:03', 1, NULL),
('9d0fbe65-36b3-4299-85c7-631b71fd40c1', 'party_type', 'provider', NULL, '2024-09-21 09:04:03', '2024-09-21 09:04:03', 1, NULL),
('9d0fbe65-397f-444c-b69f-c0864747b0d7', 'party_type', 'partner', NULL, '2024-09-21 09:04:03', '2024-09-21 09:04:03', 1, NULL);
```

