<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerFeature\Zed\SspInquiryManagement\Business\Reader;

use Generated\Shared\Transfer\SspInquiryCollectionTransfer;
use Generated\Shared\Transfer\SspInquiryCriteriaTransfer;
use Spryker\Zed\Kernel\PermissionAwareTrait;
use SprykerFeature\Zed\SspInquiryManagement\Persistence\SspInquiryManagementRepositoryInterface;

class SspInquiryReader implements SspInquiryReaderInterface
{
    use PermissionAwareTrait;

    /**
     * @param \SprykerFeature\Zed\SspInquiryManagement\Persistence\SspInquiryManagementRepositoryInterface $sspInquiryManagementRepository
     * @param array<int, \SprykerFeature\Zed\SspInquiryManagement\Business\Expander\SspInquiryExpanderInterface> $sspInquiryExpanders
     */
    public function __construct(
        protected SspInquiryManagementRepositoryInterface $sspInquiryManagementRepository,
        protected array $sspInquiryExpanders
    ) {
    }

    /**
     * @param \Generated\Shared\Transfer\SspInquiryCriteriaTransfer $sspInquiryCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\SspInquiryCollectionTransfer
     */
    public function getSspInquiryCollection(SspInquiryCriteriaTransfer $sspInquiryCriteriaTransfer): SspInquiryCollectionTransfer
    {
        $sspInquiryCollectionTransfer = $this->sspInquiryManagementRepository->getSspInquiryCollection($sspInquiryCriteriaTransfer);
        foreach ($this->sspInquiryExpanders as $sspInquiryExpander) {
            if (!$sspInquiryExpander->isApplicable($sspInquiryCriteriaTransfer)) {
                continue;
            }

             $sspInquiryCollectionTransfer = $sspInquiryExpander->expand($sspInquiryCollectionTransfer);
        }

        return $sspInquiryCollectionTransfer;
    }
}
