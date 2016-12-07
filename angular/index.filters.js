import {CapitalizeFilter} from './filters/capitalize.filter';
import {HumanReadableFilter} from './filters/human_readable.filter';
import {TruncatCharactersFilter} from './filters/truncate_characters.filter';
import {TruncateWordsFilter} from './filters/truncate_words.filter';
import {TrustHtmlFilter} from './filters/trust_html.filter';
import {UcFirstFilter} from './filters/ucfirst.filter';
import {SecondsToDateTimeFilter} from './filters/seconds_to_date_time.filter';

angular.module('app.filters')
	.filter('capitalize', CapitalizeFilter)
	.filter('humanReadable', HumanReadableFilter)
	.filter('truncateCharacters', TruncatCharactersFilter)
	.filter('truncateWords', TruncateWordsFilter)
	.filter('trustHtml', TrustHtmlFilter)
	.filter('ucfirst', UcFirstFilter)
	.filter('secondsToDateTime', SecondsToDateTimeFilter);
