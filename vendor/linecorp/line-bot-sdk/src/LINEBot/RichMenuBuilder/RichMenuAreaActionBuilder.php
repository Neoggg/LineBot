<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace LINE\LINEBot\RichMenuBuilder;

use LINE\LINEBot\TemplateActionBuilder;

/**
 * A builder class for area of rich menu area object.
 *
 * @package LINE\LINEBot\RichMenuBuilder
 */
class RichMenuAreaActionBuilder implements TemplateActionBuilder
{
    /** @var string */
    private $type;
    /** @var string */
    private $data;
    /** @var string */
    private $label;

    public function __construct($type, $label, $data)
    {
        $this->type = $type;
        $this->label = $label;
        $this->data = $data;
    }

    /**
     * Builds imagemap area structure.
     *
     * @return array Built area structure.
     */
    public function buildTemplateAction()
    {
        return [
            'type' => $this->type,
            'label' => $this->label,
            'data' => $this->data,
        ];
    }
}
