<?php

echo wordwrap('Pozdrav, '.$user->name.'.

Dobili ste ovaj email kako biste mogli potvrditi svoju email adresu. Morate potvrditi email adresu ukoliko želite primati obavijesti na email.

Otvorite sljedeći URL (link) u Vašem Web pregledniku kako biste potvrdili registraciju:
http://'.Kohana::config('common.domain').'/profil/potvrda_emaila/'.$user->id.'/'.$user->email_confirm, 70);
