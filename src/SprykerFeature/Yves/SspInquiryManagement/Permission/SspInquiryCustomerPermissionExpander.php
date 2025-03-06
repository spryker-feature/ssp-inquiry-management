<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerFeature\Yves\SspInquiryManagement\Permission;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\SspInquiryConditionsTransfer;
use Spryker\Yves\Kernel\PermissionAwareTrait;
use SprykerFeature\Shared\SspInquiryManagement\Plugin\Permission\ViewBusinessUnitSspInquiryPermissionPlugin;
use SprykerFeature\Shared\SspInquiryManagement\Plugin\Permission\ViewCompanySspInquiryPermissionPlugin;

class SspInquiryCustomerPermissionExpander implements SspInquiryCustomerPermissionExpanderInterface
{
    use PermissionAwareTrait;

    /**
     * @param \Generated\Shared\Transfer\SspInquiryConditionsTransfer $sspInquiryConditionsTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\SspInquiryConditionsTransfer
     */
    public function extendSspInquiryCriteriaTransferWithPermissions(
        SspInquiryConditionsTransfer $sspInquiryConditionsTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): SspInquiryConditionsTransfer {
         $sspInquiryConditionsTransfer->getSspInquiryOwnerConditionGroupOrFail()->setFkCompanyUser($companyUserTransfer->getIdCompanyUser());

        if ($this->can(ViewCompanySspInquiryPermissionPlugin::KEY)) {
             $sspInquiryConditionsTransfer->getSspInquiryOwnerConditionGroupOrFail()->setFkCompany($companyUserTransfer->getFkCompany());
        }

        if ($this->can(ViewBusinessUnitSspInquiryPermissionPlugin::KEY)) {
             $sspInquiryConditionsTransfer->getSspInquiryOwnerConditionGroupOrFail()->setFkCompanyBusinessUnit($companyUserTransfer->getFkCompanyBusinessUnit());
        }

        return $sspInquiryConditionsTransfer;
    }
}
