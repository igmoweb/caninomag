const { SelectControl } = wp.components;

const AdsEdit = ( { attributes, setAttributes, className } ) => (
	<div className={`${className} ad-size-${attributes.size}`}>
		<SelectControl
			label="Tamaño"
			value={ attributes.size }
			options={ [
				{ label: 'Leaderboard (728x90)', value: 'leaderboard' },
				{ label: 'Rect. Mediano (300x250)', value: 'medium' },
			] }
			onChange={ ( size ) => { setAttributes( { size } ) } }
		/>
	</div>
);

export default AdsEdit;
