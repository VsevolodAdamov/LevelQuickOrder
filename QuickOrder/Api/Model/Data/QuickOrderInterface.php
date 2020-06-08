<?php

namespace Level\QuickOrder\Api\Model\Data;


interface QuickOrderInterface
{
    const CACHE_TAG                 = 'Level_quickorder';

    const REGISTRY_KEY              = 'Level_quickorder_lesson';

    const ID_FIELD                  = 'order_id';
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param string $name
     * @return QuickOrderInterface
     */

    public function setName(string $name);

    /**
     * @return string
     */

    public function getName();

    /**
     * @param string $sku
     * @return QuickOrderInterface
     */

    public function setSku(string $sku);

    /**
     * @return string
     */

    public function getSku();

    /**
     * @param string $phone
     * @return QuickOrderInterface
     */

    public function setPhone(string $phone);

    /**
     * @return string
     */

    public function getPhone();

    /**
     * @param string $email
     * @return QuickOrderInterface
     */

    public function setEmail(string $email);

    /**
     * @return string
     */

    public function getEmail();

    /**
     * @param StatusInterface $status
     * @return QuickOrderInterface
     */

    public function setStatus(StatusInterface $status);

    /**
     * @return StatusInterface
     */

    public function getStatus();


    public function getCreatedAt() : \DateTimeInterface;

    public function getUpdatedAt(): \DateTimeInterface;
}
