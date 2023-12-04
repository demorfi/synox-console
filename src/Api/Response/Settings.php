<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Response;

use SynoxWebApi\Api\{ResponsePrototype, Skeleton\Setting};

class Settings extends ResponsePrototype
{
    /**
     * @return iterable|Setting
     */
    public function getApp(): iterable|Setting
    {
        foreach ($this->response['app'] as $name => $value) {
            yield new Setting($this->api, 'app', $name, $value);
        }
    }

    /**
     * @return Setting
     */
    public function getAppLimitPerPackage(): Setting
    {
        return new Setting($this->api, 'app', 'limitPerPackage', $this->getApp()['limitPerPackage']);
    }

    /**
     * @return Setting
     */
    public function getAppUseJournal(): Setting
    {
        return new Setting($this->api, 'app', 'useJournal', $this->getApp()['useJournal']);
    }

    /**
     * @return Setting
     */
    public function getAppMaxJournalRecords(): Setting
    {
        return new Setting($this->api, 'app', 'maxJournalRecords', $this->getApp()['maxJournalRecords']);
    }
}