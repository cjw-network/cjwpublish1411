<?php

namespace Netgen\TagsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use eZ\Bundle\EzPublishCoreBundle\Controller;
use Netgen\TagsBundle\API\Repository\TagsService;
use Netgen\TagsBundle\API\Repository\Values\Tags\Tag;
use Netgen\TagsBundle\Core\Pagination\Pagerfanta\RelatedContentAdapter;
use Pagerfanta\Pagerfanta;

class TagViewController extends Controller
{
    /**
     * @var \Netgen\TagsBundle\API\Repository\TagsService
     */
    protected $tagsService;

    /**
     * Constructor
     *
     * @param \Netgen\TagsBundle\API\Repository\TagsService $tagsService
     */
    public function __construct( TagsService $tagsService )
    {
        $this->tagsService = $tagsService;
    }

    /**
     * Action for rendering a tag view by using tag ID
     *
     * @param mixed $tagId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewTagById( $tagId )
    {
        $tag = $this->tagsService->loadTag( $tagId );
        return $this->renderTag( $tag );
    }

    /**
     * Action for rendering a tag view by using tag URL
     *
     * @param string $tagUrl
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewTagByUrl( $tagUrl )
    {
        $tag = $this->tagsService->loadTagByUrl( $tagUrl );
        return $this->renderTag( $tag );
    }

    /**
     * Renders the tag
     *
     * @param \Netgen\TagsBundle\API\Repository\Values\Tags\Tag $tag
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderTag( Tag $tag )
    {
        $pager = new Pagerfanta(
            new RelatedContentAdapter( $tag, $this->tagsService )
        );

        $pager->setMaxPerPage( $this->getConfigResolver()->getParameter( 'tag_view.related_content_list.limit', 'eztags' ) );
        $pager->setCurrentPage( $this->getRequest()->get( 'page', 1 ) );

        $response = new Response();
        $response->headers->set( 'X-Tag-Id', $tag->id );

        if ( $this->getConfigResolver()->getParameter( 'tag_view.cache', 'eztags' ) === true )
        {
            $response->setPublic();
            if ( $this->getConfigResolver()->getParameter( 'tag_view.ttl_cache', 'eztags' ) === true )
            {
                $response->setSharedMaxAge(
                    $this->getConfigResolver()->getParameter( 'tag_view.default_ttl', 'eztags' )
                );
            }

            // Make the response vary against X-User-Hash header ensures that an HTTP
            // reverse proxy caches the different possible variations of the
            // response as it can depend on user role for instance.
            if ( $this->getRequest()->headers->has( 'X-User-Hash' ) )
            {
                $response->setVary( 'X-User-Hash' );
            }

            $response->setLastModified( $tag->modificationDate );
        }

        return $this->render(
            'NetgenTagsBundle:tag:view.html.twig',
            array(
                'tag' => $tag,
                'pager' => $pager
            ),
            $response
        );
    }
}
