<?php

namespace Zigzag\Controllers;

class PublicForms extends BaseController {
	
	public function mainForm() {
		$data['eventId'] = 13;
		$data['nameOfEvent'] = 'Dummy PSX';
		$data['categories'] = [
			[
				'id' => 1,
				'name' => 'Level lekce',
				'description' => 'Zvolte prosím, jaký level swingu Vám odpovídá',
				'options' => [
					[
						'id' => 66,
						'name' => 'Začátečník',
						'info' => 'Nikdy jsem netančil!'
					],
					[
						'id' => 67,
						'name' => 'Mírně pokročilý',
						'info' => 'Umím počítat do šesti, do osmi a nepadám co pět minut'
					],
					[
						'id' => 68,
						'name' => 'Pokročilý',
						'info' => 'Aereals a jazz steps jsou moje druhé já'
					],
				],
			],
			[
				'id' => 2,
				'name' => 'Sobotní oběd',
				'description' => 'Vyberte si, na jaký oběd máte v sobotu chuť',
				'options' => [
					[
						'id' => 69,
						'name' => 'Bramboráky',
						'info' => 'Pozor na lepek!'
					],
					[
						'id' => 70,
						'name' => 'Goulasch',
						'info' => 'Pravý český s pěti'
					],
					[
						'id' => 71,
						'name' => 'Salát',
						'info' => 'Vlastně moc nedpopručujeme - je v něm spousta zeleniny a ovoce (například oliv či rajčat) a tedy není výživově příliš vhodný pro náročné vypětí sil, jaké na lekcích budou'
					],
				]
			],
			[
				'id' => 3,
				'name' => 'Tričko',
				'description' => 'Chcete tričko? Tady máto možnost ho objednat!',
				'options' => [
					[
						'id' => 72,
						'name' => 'Nechci tričko',
						'info' => ''
					],
					[
						'id' => 73,
						'name' => 'pánské XL',
						'info' => ''
					],
					[
						'id' => 74,
						'name' => 'dámské XL',
						'info' => ''
					],
					[
						'id' => 75,
						'name' => 'dámské L',
						'info' => ''
					],
					[
						'id' => 76,
						'name' => 'pánské L',
						'info' => ''
					],
					[
						'id' => 77,
						'name' => 'dámské M',
						'info' => 'malé'
					],
					[
						'id' => 78,
						'name' => 'pánské M',
						'info' => 'menší než malé'
					],
				],
			],
		];
		
		$html = $this->renderer->render('mainForm', $data);
		$this->response->setContent($html);
	}
}