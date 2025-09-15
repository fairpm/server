export default function getLocalization(stringKey) {
	let localizations = {};
	const localization_source = document.getElementById(
		'wp-script-module-data-scripts'
	);
	if ( localization_source?.textContent ) {
		try {
			localizations = JSON.parse( localization_source.textContent );
			return localizations[stringKey];
		} catch {
			console.error(`Missing translation for ${stringKey}`);
			return '';
		}
	}
}
