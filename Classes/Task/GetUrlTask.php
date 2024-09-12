<?php
namespace WebentwicklerAt\SchedulerHttp\Task;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Localization\LanguageService;

/**
 * Scheduler task for making GET-Requests.
 */
class GetUrlTask extends AbstractTask
{
    /**
     * URL
     *
     * @var string
     */
    public $url;
    
    /**
     * Function execute from the Scheduler
     *
     * @return bool TRUE on successful execution, FALSE on error
     */
    public function execute(): bool
    {
        /** @var RequestFactory $requestFactory */
        $requestFactory = GeneralUtility::makeInstance(RequestFactory::class);
        
        try {
            // Send a GET request to the provided URL
            $response = $requestFactory->request($this->url, 'GET');
            // Check if the response status is successful (200-299)
            return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
        } catch (\Exception $e) {
            // Log the exception (optional)
            return false;
        }
    }
    
    
    /**
     * Get the url
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }
    
    /**
     * Set the value of the private property csvfile.
     *
     * @param string $csvfile Path to the csv file
     * @return void
     */
    public function setUrl($url) {
        $this->url = $url;
    }
    
    /**
     * This method returns the configured URL as additional information
     *
     * @return string
     */
    public function getAdditionalInformation(): string
    {
        $languageService = $this->getLanguageService();
        return sprintf(
            $languageService->sL('LLL:EXT:scheduler_http/Resources/Private/Language/locallang.xlf:label.getUrl.additionalInformationUrl'),
            $this->url
            );
    }
    
    /**
     * Gets the LanguageService instance
     *
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'] ?? GeneralUtility::makeInstance(LanguageService::class);
    }
}
