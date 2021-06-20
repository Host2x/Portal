<?php

namespace Host2x\Portal;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installStep1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_forum', function (Alter $table) {
            $table->addColumn('host2x_portal_auto_feature', 'tinyint')->setDefault(0);
        });
    }

    public function installStep2()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_thread', function (Alter $table) {
            $table->addColumn('host2x_portal_featured', 'tinyint')->setDefault(0);
        });
    }

    public function installStep3()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->createTable('host2x_portal_featured_thread', function (Create $table) {
            $table->addColumn('thread_id', 'int');
            $table->addColumn('featured_date', 'int');
            $table->addPrimaryKey('thread_id');
        });
    }

    public function installStep4()
    {
        $this->createWidget('host2x_portal_view_members_online', 'members_online', [
            'positions' => ['host2x_portal_view_sidebar' => 10]
        ]);

        $this->createWidget('host2x_portal_view_new_posts', 'new_posts', [
            'positions' => ['host2x_portal_view_sidebar' => 20]
        ]);

        $this->createWidget('host2x_portal_view_new_profile_posts', 'new_profile_posts', [
            'positions' => ['host2x_portal_view_sidebar' => 30]
        ]);

        $this->createWidget('host2x_portal_view_forum_statistics', 'forum_statistics', [
            'positions' => ['host2x_portal_view_sidebar' => 40]
        ]);

        $this->createWidget('host2x_portal_view_share_page', 'share_page', [
            'positions' => ['host2x_portal_view_sidebar' => 50]
        ]);
    }

    public function uninstallStep1()
    {
        $this->schemaManager()->alterTable('xf_forum', function(Alter $table)
        {
            $table->dropColumns('host2x_portal_auto_feature');
        });
    }

    public function uninstallStep2()
    {
        $this->schemaManager()->alterTable('xf_thread', function(Alter $table)
        {
            $table->dropColumns('host2x_portal_featured');
        });
    }

    public function uninstallStep3()
    {
        $this->schemaManager()->dropTable('host2x_portal_featured_thread');
    }
}