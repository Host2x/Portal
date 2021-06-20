<?php

namespace Host2x\Portal\Pub\Controller;

use Host2x\Portal\Entity\FeaturedThread;
use XF\Pub\Controller\AbstractController;

class Portal extends AbstractController
{
    public function actionIndex()
    {
        $page = $this->filterPage();
        $perPage = $this->options()->host2xPortalFeaturedPerPage;

        /** @var \Host2x\Portal\Repository\FeaturedThread $repo */
        $repo = $this->repository('Host2x\Portal:FeaturedThread');

        $finder = $repo->findFeaturedThreadsForPortalView()
            ->limit($perPage * 3);

        $featuredThreads = $finder->fetch()
            ->filter(function (FeaturedThread $featuredThread){
                return ($featuredThread->Thread->canView());
            })
            ->sliceToPage($page, $perPage);

        $threads = $featuredThreads->pluckNamed('Thread');
        $posts = $threads->pluckNamed('FirstPost', 'first_post_id');

        /** @var \XF\Repository\Attachment $attachRepo */
        $attachRepo = $this->repository('XF:Attachment');
        $attachRepo->addAttachmentsToContent($posts, 'post');

        $viewParams = [
            'featuredThreads' => $featuredThreads,
            'total' => $finder->total(),
            'page' => $page,
            'perPage' => $perPage,
        ];

        return $this->view('Host2x\Portal:View', 'host2x_portal_view', $viewParams);
    }
}