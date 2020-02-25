<?php
namespace chaofei\ajaxmodal;

use yii\base\Widget;

class AjaxModalWidget extends Widget
{
    public function run()
    {
        /**
         * @see https://www.yiiframework.com/wiki/806/render-form-in-popup-via-ajax-create-and-update-with-ajax-validation-also-load-any-page-via-ajax-yii-2-0-2-3#how-to-use-a-modal-with-ajax-below-is-any-item-via-ajax
         */
        return $this->render('@vendor/dchaofei/yii2-ajaxmodal/view/ajax-modal');
    }
}