const { SelectControl } = wp.components;

const AdsEdit = ( { attributes, setAttributes, className } ) => (
	<div className={`${className} ad-size-${attributes.size}`}>
		<SelectControl
			label="Tamaño del anuncio"
			value={ attributes.size }
			options={ [
				{ label: 'Auto', value: 'auto' },
				{ label: 'Horizontal', value: 'horizontal' },
				{ label: 'Vertical', value: 'vertical' },
			] }
			onChange={ ( size ) => { setAttributes( { size } ) } }
		/>
	</div>
);

export default AdsEdit;
