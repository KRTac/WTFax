<?php

$domain = Kohana::config('main.domain');

echo wordwrap('Pozdrav, '.$user->name.'.

Dobili ste ovaj email zbog zahtjeva za resetiranje lozinke.

Kako bi postavili novu lozinku otvorite sljedeči URL u Vašem web pregledniku:
http://'.$domain.'/password/reset/'.$user->id.'/'.$user->password_recovery_hash.'

Zanemarite ovaj email ukoliko niste podnijeli zahtjev za resetiranje lozinke.', 70);
