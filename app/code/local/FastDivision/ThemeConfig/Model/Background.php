<?php
/**
 * Avalanche for Magento 1.6+
 * Designed by Fast Division (http://fastdivision.com)
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://fastdivision.com/legal/license.txt
 *
 * @author     Fast Division
 * @version    1.3.0
 * @copyright  Copyright 2012 Fast Division
 * @license    http://fastdivision.com/legal/license.txt
 */

class FastDivision_ThemeConfig_Model_Background {
    public function toOptionArray() {
        return array(
            array('value'=>'#f0f0f0 url(\'../images/bg1.jpg\')', 'label'=>Mage::helper('themeconfig')->__('Light Noise (Original)')),

            array('value'=>'#f0f0f0 url(\'../images/backgrounds/bright_squares.jpg\')', 'label'=>Mage::helper('themeconfig')->__('Bright Squares')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/circles.png\')', 'label'=>Mage::helper('themeconfig')->__('Circles')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/cubes.png\')', 'label'=>Mage::helper('themeconfig')->__('Cubes')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/diagonal-noise.png\')', 'label'=>Mage::helper('themeconfig')->__('Diagonal Noise')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/fancy_deboss.png\')', 'label'=>Mage::helper('themeconfig')->__('Fancy Deboss')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/foggy_birds.png\')', 'label'=>Mage::helper('themeconfig')->__('Foggy Birds')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/graphy.png\')', 'label'=>Mage::helper('themeconfig')->__('Graphy')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/grilled.png\')', 'label'=>Mage::helper('themeconfig')->__('Grilled')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/groovepaper.jpg\')', 'label'=>Mage::helper('themeconfig')->__('Groovepaper')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/grunge_wall.jpg\')', 'label'=>Mage::helper('themeconfig')->__('Grunge Wall')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/lined_paper.png\')', 'label'=>Mage::helper('themeconfig')->__('Lined Paper')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/noise_pattern_with_crosslines.png\')', 'label'=>Mage::helper('themeconfig')->__('Noise + Crosslines')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/old_wall.jpg\')', 'label'=>Mage::helper('themeconfig')->__('Old Wall')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/project_paper.png\')', 'label'=>Mage::helper('themeconfig')->__('Project Paper')),    
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/ravenna.jpg\')', 'label'=>Mage::helper('themeconfig')->__('Ravenna')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/ricepaper2.jpg\')', 'label'=>Mage::helper('themeconfig')->__('Rice Paper')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/small_tiles.png\')', 'label'=>Mage::helper('themeconfig')->__('Small Tiles')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/struckaxiom.png\')', 'label'=>Mage::helper('themeconfig')->__('Struck Axiom')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/stucco.png\')', 'label'=>Mage::helper('themeconfig')->__('Stucco')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/subtle_freckles.png\')', 'label'=>Mage::helper('themeconfig')->__('Subtle Freckles')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/wavecut.png\')', 'label'=>Mage::helper('themeconfig')->__('Wavecut')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/white-fabric.jpg\')', 'label'=>Mage::helper('themeconfig')->__('White Fabric')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/whitediamond.jpg\')', 'label'=>Mage::helper('themeconfig')->__('White Diamond')),
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/wood_pattern.jpg\')', 'label'=>Mage::helper('themeconfig')->__('Wood')),          
            array('value'=>'#f0f0f0 url(\'../images/backgrounds/xv.jpg\')', 'label'=>Mage::helper('themeconfig')->__('XV')),
        );
    }
}