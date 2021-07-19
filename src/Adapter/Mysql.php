<?php

namespace ipl\Sql\Adapter;

use ipl\Sql\Config;
use ipl\Sql\Connection;
use PDO;

class Mysql extends BaseAdapter
{
    protected $quoteCharacter = ['`', '`'];

    protected $escapeCharacter = '``';

    public function setClientTimezone(Connection $db)
    {
        $db->exec('SET time_zone = ' . $db->quote($this->getTimezoneOffset()));

        return $this;
    }

    public function getOptions(Config $config)
    {
        $options = parent::getOptions($config);

        if (isset($config->use_ssl) && $config->use_ssl === '1') {
            if (isset($config->ssl_key)) {
                $options[PDO::MYSQL_ATTR_SSL_KEY] = $config->ssl_key;
            }

            if (isset($config->ssl_cert)) {
                $options[PDO::MYSQL_ATTR_SSL_CERT] = $config->ssl_cert;
            }

            if (isset($config->ssl_ca)) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = $config->ssl_ca;
            }

            if (isset($config->ssl_capath)) {
                $options[PDO::MYSQL_ATTR_SSL_CAPATH] = $config->ssl_capath;
            }

            if (isset($config->ssl_cipher)) {
                $options[PDO::MYSQL_ATTR_SSL_CIPHER] = $config->ssl_cipher;
            }

            if (
                defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')
                && isset($config->ssl_do_not_verify_server_cert)
            ) {
                $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
            }
        }

        return $options;
    }
}
