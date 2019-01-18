<?php

namespace AppBundle\Model\Representation;

use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @JMS\ExclusionPolicy("all")
 *
 * @OA\Schema()
 */
class PaginatedRepresentation
{
    /**
     * @var int
     *
     * @OA\Property()
     *
     * @JMS\Expose()
     * @JMS\Groups({"pagination"})
     */
    private $currentPageNumber;

    /**
     * @var int
     *
     * @OA\Property()
     *
     * @JMS\Expose()
     * @JMS\Groups({"pagination"})
     */
    private $numItemsPerPage;

    /**
     * @var int
     *
     * @OA\Property()
     *
     * @JMS\Expose()
     * @JMS\Groups({"pagination"})
     */
    private $totalCount;

    /**
     * @var int
     *
     * @OA\Property()
     *
     * @JMS\Expose()
     * @JMS\Groups({"pagination"})
     */
    private $totalPages;

    /**
     * @var array
     *
     * @OA\Property(@OA\Items())
     *
     * @JMS\Expose()
     * @JMS\Groups({"pagination"})
     */
    private $items = array();

    /**
     * @param PaginationInterface $pagination
     * @return PaginatedRepresentation
     */
    public static function createFromPaginationInterface(PaginationInterface $pagination)
    {
        $representation = (new self())
            ->setNumItemsPerPage($pagination->getItemNumberPerPage())
            ->setCurrentPageNumber($pagination->getCurrentPageNumber())
            ->setTotalPages(ceil($pagination->getTotalItemCount() / $pagination->getItemNumberPerPage()))
            ->setTotalCount($pagination->getTotalItemCount())
            ->setItems($pagination->getItems());

        return $representation;
    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * @param int $totalPages
     * @return PaginatedRepresentation
     */
    public function setTotalPages($totalPages)
    {
        $this->totalPages = $totalPages;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentPageNumber()
    {
        return $this->currentPageNumber;
    }

    /**
     * @param int $currentPageNumber
     * @return PaginatedRepresentation
     */
    public function setCurrentPageNumber($currentPageNumber)
    {
        $this->currentPageNumber = $currentPageNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumItemsPerPage()
    {
        return $this->numItemsPerPage;
    }

    /**
     * @param int $numItemsPerPage
     * @return PaginatedRepresentation
     */
    public function setNumItemsPerPage($numItemsPerPage)
    {
        $this->numItemsPerPage = $numItemsPerPage;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return PaginatedRepresentation
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @param int $totalCount
     * @return PaginatedRepresentation
     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;

        return $this;
    }
}