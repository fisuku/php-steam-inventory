<?php

namespace SteamInventory;


use SteamInventory\Entity\ItemPair;

class ItemIterator implements \Iterator {
    private $globalPos = 0;
    private $pagePos = 0;
    private $container;

    public function __construct(InventoryContainer $inventoryIterator) {
        $this->container = $inventoryIterator;
    }

    public function next() {
        $this->globalPos++;
        $this->pagePos++;

        if (!$this->current()) {
            $this->container->nextPage();
            $this->pagePos = 0;
        }
    }

    /**
     * @return null|ItemPair
     */
    public function current() {
        return $this->container->getCurrentPage()->getItem($this->pagePos) ?? null;
    }

    public function key() {
        return $this->globalPos;
    }

    public function valid() {
        return $this->container->getCurrentPage() && $this->current() !== null;
    }

    public function rewind() {
        $this->globalPos = 0;
        $this->pagePos = 0;
        $this->container->nextPage();
    }
}