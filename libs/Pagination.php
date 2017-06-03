<?php

/**
 * Author: ahmed-dinar
 * Date: 5/31/17
 */
class Pagination
{
    protected $curPage;
    protected $limit;
    protected $total;

    public function __construct($curPage, $page_limit, $total){
        $this->curPage = $curPage;
        $this->limit = $page_limit;
        $this->total = $total;
    }

    /**
     * Pagination offset
     * @return mixed
     */
    public function offset(){
        return ($this->curPage - 1) * $this->limit;
    }

    /**
     * Total pages of pagination
     * @return float
     */
    public function totalPages(){
        return ceil($this->total/$this->limit);
    }

    /**
     * Previous page
     * @return mixed
     */
    public function prevPage(){
        return $this->curPage - 1;
    }

    /**
     * Next page
     * @return mixed
     */
    public function nextPage(){
        return $this->curPage + 1;
    }

    /**
     * If previous page exists
     * @return bool
     */
    public function hasPrevPage(){
        return $this->prevPage() > 0;
    }

    /**
     * @return mixed
     */
    public function getLimit(){
        return $this->limit;
    }

    /**
     * @return mixed
     */
    public function getCurPage(){
        return $this->curPage;
    }

    /**
     * @return mixed
     */
    public function getTotal(){
        return $this->total;
    }

    /**
     * If next page exists
     * @return bool
     */
    public function hasNextPage(){
        return $this->nextPage() <= $this->totalPages();
    }
}