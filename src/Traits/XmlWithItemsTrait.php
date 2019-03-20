<?php

namespace ComprobanteElectronico\Traits;

use TenQuality\Data\Collection;
use ComprobanteElectronico\Data\Item;

/**
 * Trait used for XML models with items.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
trait XmlWithItemsTrait
{
    /**
     * Model constructor that initializes items collection.
     * @since 1.0.0
     * 
     * @param array $attributes Model attributes.
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->items = new Collection;
    }
    /**
     * Adds an item to invoice.
     * @since 1.0.0
     * 
     * @param \ComprobanteElectronico\Data\Item $item Item to add.
     * 
     * @return this for chaining
     */
    public function add(Item $item)
    {
        $this->items[] = $item;
        return $this;
    }
    /**
     * Runs validation on all items.
     * @since 1.0.0
     */
    protected function areItemsValid()
    {
        // Validate items
        if ($this->items)
            for ($i = 0; $i < count($this->items); ++$i) {
                $this->items[$i]->isValid();
            }
    }
}