import sanitizeHTML from 'sanitize-html';

const { RichText, } = wp.editor;
const { select } = wp.data;

const encodeTweetURL = ( content ) => {
	let sanitized = clearTweetContent( content );
	sanitized = sanitized.replace( /<br\s?\/>/g, '\n' )
	return encodeURIComponent( sanitized );
};

const clearTweetContent = ( content ) => {
	return sanitizeHTML( content, {
		allowedTags: [ 'p', 'br' ],
		transformTags: {
			'p': function() {
				return {
					tagName: 'br',
				};
			},
		}
	} );
}

const generateTwitterURL = ( content ) => {
	const text = encodeTweetURL( content );
	const via = 'caninomag';
	const permalink = select( 'core/editor' ).getPermalink();
	return `https://twitter.com/intent/tweet?text=${ text }&via=${ via }&url=${ permalink }`;
}

const ClickToTweetEdit = props => {
	const { attributes, setAttributes, className } = props;
	const { value } = attributes;
	return (
		<div className={ className }>
			<RichText
				formattingControls={ [] }
				identifier="value"
				multiline
				value={ value }
				onChange={
					( nextValue ) => setAttributes( {
						value: nextValue,
						twitterURL: generateTwitterURL( nextValue )
					} )
				}
				placeholder="Tuitea algo..."
			/>
			<div className="click-to-tweet">
				<span className="dashicons dashicons-twitter"/>Tuitea esto
			</div>
		</div>
	);
};

export default ClickToTweetEdit;
