<?php

declare(strict_types=1);

namespace App\Core\Post;

defined('ABSPATH') || exit;

use App;
use App\Core\CustomPostType\MerchantsCustomPostType;
use App\Core\Post\Merchant\Branch;
use App\Core\Post\Merchant\Promotion;
use Timber\Post;
use Timber\Term;

final class MerchantPost extends Post
{
    public $PostClass = self::class;

    /**
     * @var Branch[]
     */
    private array $branches;
    private Promotion $promotion;
    private int $countActiveBranches = 0;

    public function __construct($pid = null)
    {
        parent::__construct($pid);

        $branches = $this->meta('meta_branches') ?: [];
        $promotion = $this->meta('meta_promotion') ?: [];

        foreach ($branches as $branch) {
            $postBranch = new Branch($branch);
            $this->branches[] = $postBranch;

            if (!$postBranch->isDisableBranch()) {
                $this->countActiveBranches++;
            }
        }

        $this->promotion = new Promotion($promotion);
    }

    /**
     * @return Branch[]
     */
    public function getBranches(): array
    {
        return $this->branches;
    }

    /**
     * @return Term[]
     */
    public function categories(): array
    {
        return $this->terms(MerchantsCustomPostType::TAXONOMY_NAME);
    }

    public function category(): ?Term
    {
        $cats = $this->categories();
        if (count($cats) && isset($cats[0])) {
            return $cats[0];
        }

        return null;
    }

    public function logo(): ?array
    {
        $logo = $this->meta('logo');

        if (is_array($logo)) {
            return $logo;
        }

        return null;
    }

    public function imageUrl(): ?string
    {
        return (string)$this->meta('image');
    }

    public function getPromotion(): Promotion
    {
        return $this->promotion;
    }

    public function getCountActiveBranches(): int
    {
        return $this->countActiveBranches;
    }
}
