<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Categories extends Controller_Base {

	public function action_initialize () {
		if (!isset($_GET['ok']) || $_GET['ok'] != 'ko') {
			echo 'Abort';
			return;
		}

		$root = ORM::factory('category');
		$root->name = 'Obavijesti veleučilišta';
		$root->url_text = 'obavijesti_veleucilista';
		$root->description = '';
		$root->display = 1;
		$root->make_root();

			$multimedija = ORM::factory('category');
			$multimedija->name = 'Multimedija, oblikovanje i primjena';
			$multimedija->url_text = 'multimedija';
			$multimedija->description = '';
			$multimedija->display = 1;
			$multimedija->insert_as_last_child($root);

				$prvi = ORM::factory('category');
				$prvi->name = '1. godina multimedije';
				$prvi->url_text = '1_godina_multimedije';
				$prvi->description = '';
				$prvi->display = 1;
				$prvi->insert_as_last_child($multimedija);

					$mat1 = ORM::factory('category');
					$mat1->name = 'Matematika 1';
					$mat1->url_text = 'matematika_1';
					$mat1->description = '';
					$mat1->display = 1;
					$mat1->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Matematika 2';
					$predmet->url_text = 'matematika_2';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$fiz1 = ORM::factory('category');
					$fiz1->name = 'Fizika 1';
					$fiz1->url_text = 'fizika_1';
					$fiz1->description = '';
					$fiz1->display = 1;
					$fiz1->insert_as_last_child($prvi);

					$it = ORM::factory('category');
					$it->name = 'IT i primjena';
					$it->url_text = 'it_i_primjena';
					$it->description = '';
					$it->display = 1;
					$it->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Socijalna filozofija';
					$predmet->url_text = 'socijalna_filozofija_multimedija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Strani jezik 1';
					$predmet->url_text = 'strani_jezik_1_multimedija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Strani jezik 2';
					$predmet->url_text = 'strani_jezik_2_multimedija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Multimedija, oblikovanje i primjena';
					$predmet->url_text = 'multimedija_oblikovanje_i_primjena';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Grafičke komunikacije';
					$predmet->url_text = 'graficke_komunikacije';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Grafički alati 1';
					$predmet->url_text = 'graficki_alati_1';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Grafički alati 2';
					$predmet->url_text = 'graficki_alati_2';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Programski alati 1';
					$predmet->url_text = 'programski_alati_1';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Prezentacija informacija';
					$predmet->url_text = 'prezentacija_informacija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Oblikovanje tiskarskog medija';
					$predmet->url_text = 'oblikovanje_tiskarskog_medija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Psihologija boja';
					$predmet->url_text = 'psihologija_boja';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Kolorimetrija i multimedija';
					$predmet->url_text = 'kolorimetrija_i_multimedija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($prvi);

				$drugi = ORM::factory('category');
				$drugi->name = '2. godina multimedije';
				$drugi->url_text = '2_godina_multimedije';
				$drugi->description = '';
				$drugi->display = 1;
				$drugi->insert_as_last_child($multimedija);

					$predmet = ORM::factory('category');
					$predmet->name = 'Uvod u dig. video teh. u elektroničkim medijima';
					$predmet->url_text = 'udvtem';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Strani jezik 3';
					$predmet->url_text = 'strani_jezik_3_multimedija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Strani jezik 4';
					$predmet->url_text = 'strani_jezik_4_multimedija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Programski alati 2';
					$predmet->url_text = 'programski_alati_2';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Programski alati 3';
					$predmet->url_text = 'programski_alati_3';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Komunikologija';
					$predmet->url_text = 'komunikologija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Baze podataka i SQL';
					$predmet->url_text = 'baze_podataka_i_sql_multimedija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Vizualna kultura';
					$predmet->url_text = 'vizualna_kultura';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Vizualna psihofizika';
					$predmet->url_text = 'vizualna_psihofizika';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Statistika';
					$predmet->url_text = 'statistika';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Osnove poduzetništva';
					$predmet->url_text = 'osnove_poduzetnistva_multimedija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Medijska komunikologija';
					$predmet->url_text = 'medijska_komunikologija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Grafički dizajn';
					$predmet->url_text = 'graficki_dizajn';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Fotografija';
					$predmet->url_text = 'fotografija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

				$drugi = ORM::factory('category');
				$drugi->name = '3. godina multimedije';
				$drugi->url_text = '3_godina_multimedije';
				$drugi->description = '';
				$drugi->display = 1;
				$drugi->insert_as_last_child($multimedija);

					$predmet = ORM::factory('category');
					$predmet->name = 'Web dizajn';
					$predmet->url_text = 'web_dizajn';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Poslovna komunikologija';
					$predmet->url_text = 'poslovna_komunikologija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Medijska fotografija';
					$predmet->url_text = 'medijska_fotografija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Dizajn korisničkog sučelja';
					$predmet->url_text = 'dizajn_korisnickog_sucelja';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Stručna praksa';
					$predmet->url_text = 'strucna_praksa';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

					$predmet = ORM::factory('category');
					$predmet->name = 'Završni rad';
					$predmet->url_text = 'zavrsni_rad';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($drugi);

			$studij = ORM::factory('category');
			$studij->name = 'Elektrotehnika';
			$studij->url_text = 'elektrotehnika';
			$studij->description = '';
			$studij->display = 1;
			$studij->insert_as_last_child($root);

				$godina = ORM::factory('category');
				$godina->name = '1. godina elektrotehnike';
				$godina->url_text = '1_godina_elektrotehnike';
				$godina->description = '';
				$godina->display = 1;
				$godina->insert_as_last_child($studij);

					$predmet = ORM::factory('category');
					$predmet->name = 'Matematika 1';
					$predmet->url_text = 'matematika_1';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Matematika 2';
					$predmet->url_text = 'matematika_2';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Fizika 1';
					$predmet->url_text = 'fizika_1';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Fizika 2';
					$predmet->url_text = 'fizika_2';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Osnove elektrotehnike 1';
					$predmet->url_text = 'osnove_elektrotehnike_1';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Osnove elektrotehnike 2';
					$predmet->url_text = 'osnove_elektrotehnike_2';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Tehnička dokumentacija';
					$predmet->url_text = 'tehnička_dokumentacija';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Sigurnost i zaštita na radu';
					$predmet->url_text = 'sigurnost_i_zastita_na_radu';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Socijalna filozofija';
					$predmet->url_text = 'socijalna_filozofija_elektrotehnika';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Strani jezik 1';
					$predmet->url_text = 'strani_jezik_1_elektrotehnika';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Strani jezik 2';
					$predmet->url_text = 'strani_jezik_2_elektrotehnika';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Osnove računalnih mreža';
					$predmet->url_text = 'osnove_racunalnih_mreza';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Programski jezici i algoritmi';
					$predmet->url_text = 'programski_jezici_i_algoritmi';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

				$godina = ORM::factory('category');
				$godina->name = '2. godina elektrotehnike';
				$godina->url_text = '2_godina_elektrotehnike';
				$godina->description = '';
				$godina->display = 1;
				$godina->insert_as_last_child($studij);

					$predmet = ORM::factory('category');
					$predmet->name = 'Signali i sustavi';
					$predmet->url_text = 'signali_i_sustavi';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Mjerenja u elektrotehnici';
					$predmet->url_text = 'mjerenja_u_elektrotehnici';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Baze podataka i SQL';
					$predmet->url_text = 'baze_podataka_i_sql_elektrotehnika';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Elektronički elementi';
					$predmet->url_text = 'elektronički_elementi';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Modeliranje i simuliranje';
					$predmet->url_text = 'modeliranje_i_simuliranje';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Strani jezik 3';
					$predmet->url_text = 'strani_jezik_3_elektrotehnika';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Strani jezik 4';
					$predmet->url_text = 'strani_jezik_4_elektrotehnika';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Statistika';
					$predmet->url_text = 'statistika';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Elektronički sklopovi';
					$predmet->url_text = 'elektronicki_sklopovi';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Osnove poduzetništva';
					$predmet->url_text = 'osnove_poduzetnistva_elektrotehnika';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Građa računala';
					$predmet->url_text = 'grada_racunala';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);

					$predmet = ORM::factory('category');
					$predmet->name = 'Digitalna elektronika';
					$predmet->url_text = 'digitalna_elektronika';
					$predmet->description = '';
					$predmet->display = 1;
					$predmet->insert_as_last_child($godina);
	}

}
