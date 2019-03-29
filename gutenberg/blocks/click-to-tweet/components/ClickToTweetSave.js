const { RichText, } = wp.editor;

const ClickToTweetSave = ( { attributes } ) => {
	const { value, twitterURL } = attributes;
	return (
		<a className="click-to-tweet-link" href={ twitterURL } target="_blank" rel="noopener noreferrer">
			<RichText.Content multiline value={ value }/>
			<div className="click-to-tweet">
				<span className="dashicons dashicons-twitter"/> Tuitea esto
			</div>
		</a>
	);
};

export default ClickToTweetSave;
