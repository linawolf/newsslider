<?php

namespace T3S\Newsslider\EventListener;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureParsedEvent;
use TYPO3\CMS\Core\Utility\ArrayUtility;

class ModifyFlexformEvent
{
	public function __invoke(AfterFlexFormDataStructureParsedEvent $event): void
	{
		$dataStructure = $event->getDataStructure();
		$identifier = $event->getIdentifier();

		if ($identifier['type'] === 'tca' && $identifier['tableName'] === 'tt_content'
		 && ($identifier['dataStructureKey'] === '*,news_pi1' || $identifier['dataStructureKey'] === '*,news_newsliststicky')) {

			$swiperfile = GeneralUtility::getFileAbsFileName('EXT:newsslider/Configuration/FlexForms/Swiperslider.xml');
			$swipercontent = @file_get_contents($swiperfile);
			if ($swipercontent) {
				ArrayUtility::mergeRecursiveWithOverrule($dataStructure, GeneralUtility::xml2array($swipercontent));
			}
		}

		$event->setDataStructure($dataStructure);
	}
}
