<?php

namespace Zigzag\Controllers;

class PublicForms extends BaseController {
	
	public function mainForm() {
		$data['nameOfEvent'] = 'Dummy PSX';
		$data['categories'] = [
			[
				'name' => 'Level lekce',
				'description' => 'Zvolte prosím, jaký level swingu Vám odpovídá',
				'options' => [
					[
						'name' => 'Začátečník',
						'info' => 'Nikdy jsem netančil!'
					],
					[
						'name' => 'Mírně pokročilý',
						'info' => 'Umím počítat do šesti, do osmi a nepadám co pět minut'
					],
					[
						'name' => 'Pokročilý',
						'info' => 'Aereals a jazz steps jsou moje druhé já'
					],
				],
			],
			[
				'name' => 'Sobotní oběd',
				'description' => 'Vyberte si, na jaký oběd máte v sobotu chuť',
				'options' => [
					[
						'name' => 'Bramboráky',
						'info' => 'Pozor na lepek!'
					],
					[
						'name' => 'Goulasch',
						'info' => 'Pravý český s pěti'
					],
					[
						'name' => 'Salát',
						'info' => 'Vlastně moc nedpopručujeme - je v něm spousta zeleniny a ovoce (například oliv či rajčat) a tedy není výživově příliš vhodný pro náročné vypětí sil, jaké na lekcích budou'
					],
				]
			],
			[
				'name' => 'Tričko',
				'description' => 'Chcete tričko? Tady máto možnost ho objednat!',
				'options' => [
					[
						'name' => 'Nechci tričko',
						'info' => ''
					],
					[
						'name' => 'pánské XL',
						'info' => ''
					],
					[
						'name' => 'dámské XL',
						'info' => ''
					],
					[
						'name' => 'dámské L',
						'info' => ''
					],
					[
						'name' => 'pánské L',
						'info' => ''
					],
					[
						'name' => 'dámské M',
						'info' => 'malé'
					],
					[
						'name' => 'pánské M',
						'info' => 'malé'
					],
				],
			],
		];
		
		$html = $this->renderer->render('mainForm', $data);
		$this->response->setContent($html);
	}
}