const { registerBlockType } = wp.blocks;

export default registerBlockType( 'canino/patreon', {
	title: 'Link Patreon',
	category: 'canino',
	icon: 'megaphone',
	keywords: [
		'patreon',
	],
	edit: () => {
		return <p>
			<a href="https://www.patreon.com/canino?ty=h"><strong>¿Te ha gustado este artículo? Puedes colaborar con Canino en nuestro Patreon. Ayúdanos a seguir creciendo.</strong></a>
		</p>
	},
	save: () => {
		return <p>
			<a href="https://www.patreon.com/canino?ty=h"><strong>¿Te ha gustado este artículo? Puedes colaborar con Canino en nuestro Patreon. Ayúdanos a seguir creciendo.</strong></a>
		</p>
	}
});
