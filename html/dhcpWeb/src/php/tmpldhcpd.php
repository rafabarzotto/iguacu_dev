<?php

$default = '#ddns-update-style interim;
#ignore client-updates;
authoritative;

subnet 192.168.4.0 netmask 255.255.255.0 {
    option routers 192.168.4.253;
    option subnet-mask 255.255.255.0;
    # option domain-name "iguacucelulose.com.br";
    option domain-name-servers 8.8.8.8, 192.168.4.253;
    default-lease-time 300;
    max-lease-time 43200;
}'.PHP_EOL.PHP_EOL;

?>
