<?php
/**
 * Copyright (c) 2019
 * Copyright Holder : CompactCode - CompactCode BvBa - Belgium
 * Copyright : Unless granted permission from CompactCode BvBa.
 * You can not distribute, reuse, edit, resell or sell this.
 */

namespace CompactCode\Base\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Animations implements ArrayInterface
{
    protected $options;

    const ROTATE_SQUARE = 'rotating-square';
    const SINGLE_PING = 'single-ping';
    const DOUBLE_PING = 'double-ping';
    const RECT_STRETCH = 'rectangle-stretch';
    const CHASING_CUBES = 'chasing-cubes';
    const CHASING_DOTS = 'chasing-dots';
    const TRIPLE_BOUNCE = 'triple-bounce';
    const BOUNCING_CIRCLE = 'bouncing-circle';
    const FADING_CIRCLE = 'fading-circle';
    const CUBE_GRID = 'cube-grid';
    const FOLDING_CUBE = 'folding-cube';

    /**
     * @param bool $multiselect
     * @param null $key
     * @return array
     */
    public function toOptionArray($multiselect = false , $key = null)
    {
        if (!isset($this->options)) {
            $this->options = array(
                self::ROTATE_SQUARE => array(
                    'value' => self::ROTATE_SQUARE,
                    'label' => __('Rotate Square'),
                    'data-childclass' => '',
                    'data-children' => 0
                ),
                self::SINGLE_PING => array(
                    'value' => self::SINGLE_PING,
                    'label' => __('Single Ping'),
                    'data-childclass' => '',
                    'data-children' => 0
                ),
                self::DOUBLE_PING => array(
                    'value' => self::DOUBLE_PING,
                    'label' => __('Double Ping'),
                    'data-childclass' => 'double-ping',
                    'data-children' => 2

                ),
                self::RECT_STRETCH => array(
                    'value' => self::RECT_STRETCH,
                    'label' => __('Rectangular Stretch'),
                    'data-childclass' => 'rect',
                    'data-children' => 5
                ),
                self::CHASING_CUBES => array(
                    'value' => self::CHASING_CUBES,
                    'label' => __('Chasing Cubes'),
                    'data-childclass' => 'cube',
                    'data-children' => 2
                ),
                self::CHASING_DOTS => array(
                    'value' => self::CHASING_DOTS,
                    'label' => __('Chasing Dots'),
                    'data-childclass' => 'dot',
                    'data-children' => 2
                ),
                self::TRIPLE_BOUNCE => array(
                    'value' => self::TRIPLE_BOUNCE,
                    'label' => __('Triple Bounce'),
                    'data-childclass' => 'bounce',
                    'data-children' => 3
                ),
                self::BOUNCING_CIRCLE => array(
                    'value' => self::BOUNCING_CIRCLE,
                    'label' => __('Bouncing Circle'),
                    'data-childclass' => 'circle',
                    'data-children' => 12
                ),
                self::FADING_CIRCLE => array(
                    'value' => self::FADING_CIRCLE,
                    'label' => __('Fading Circle'),
                    'data-childclass' => 'circle',
                    'data-children' => 12
                ),
                self::CUBE_GRID => array(
                    'value' => self::CUBE_GRID,
                    'label' => __('Cube Grid'),
                    'data-childclass' => 'cube',
                    'data-children' => 9
                ),
                self::FOLDING_CUBE => array(
                    'value' => self::FOLDING_CUBE,
                    'label' => __('Folding Cube'),
                    'data-childclass' => 'cube',
                    'data-children' => 4
                ),
            );
        }
        if(isset($key) && key_exists($key, $this->options)){
            return $this->options[$key];
        }
        return $this->options;
    }

    public function getOneOption($option){
        if(isset($option) && $option !== false){
            return $this->toOptionArray(false , $option);
        }
        return null;
    }
}