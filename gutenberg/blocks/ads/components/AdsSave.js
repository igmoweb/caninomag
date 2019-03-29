const AdsSave = ( { attributes } ) => {
	const { size } = attributes;

	let width = 0;
	let height = 0;
	switch ( size ) {
		case 'leaderboard': {
			width = 748;
			height = 90;
			break;
		}
		case 'medium': {
			width = 300;
			height = 250;
			break;
		}
	}
	return (
		<ins
			className="adsbygoogle"
			style={`display:inline-block;width:${ width }px;height:${ height }px`}
			data-ad-client="ca-pub-8311800129241191"
			data-ad-slot="1748594590"
		/>
	);
};

export default AdsSave;
