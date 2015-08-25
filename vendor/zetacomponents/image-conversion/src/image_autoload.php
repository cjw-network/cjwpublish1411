<?php
/**
 * Autoloader definition for the ImageConversion component.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package ImageConversion
 */

return array(
    'ezcImageException'                            => 'ImageConversion/exceptions/exception.php',
    'ezcImageFileNameInvalidException'             => 'ImageConversion/exceptions/file_name_invalid.php',
    'ezcImageFileNotProcessableException'          => 'ImageConversion/exceptions/file_not_processable.php',
    'ezcImageFilterFailedException'                => 'ImageConversion/exceptions/filter_failed.php',
    'ezcImageFilterNotAvailableException'          => 'ImageConversion/exceptions/filter_not_available.php',
    'ezcImageHandlerNotAvailableException'         => 'ImageConversion/exceptions/handler_not_available.php',
    'ezcImageHandlerSettingsInvalidException'      => 'ImageConversion/exceptions/handler_settings_invalid.php',
    'ezcImageInvalidFilterParameterException'      => 'ImageConversion/exceptions/invalid_filter_parameter.php',
    'ezcImageInvalidReferenceException'            => 'ImageConversion/exceptions/invalid_reference.php',
    'ezcImageMimeTypeUnsupportedException'         => 'ImageConversion/exceptions/mime_type_unsupported.php',
    'ezcImageMissingFilterParameterException'      => 'ImageConversion/exceptions/missing_filter_parameter.php',
    'ezcImageTransformationAlreadyExistsException' => 'ImageConversion/exceptions/transformation_already_exists.php',
    'ezcImageTransformationException'              => 'ImageConversion/exceptions/transformation.php',
    'ezcImageTransformationNotAvailableException'  => 'ImageConversion/exceptions/transformation_not_available.php',
    'ezcImageHandler'                              => 'ImageConversion/interfaces/handler.php',
    'ezcImageMethodcallHandler'                    => 'ImageConversion/interfaces/methodcall_handler.php',
    'ezcImageColorspaceFilters'                    => 'ImageConversion/interfaces/colorspace.php',
    'ezcImageEffectFilters'                        => 'ImageConversion/interfaces/effect.php',
    'ezcImageGdBaseHandler'                        => 'ImageConversion/handlers/gd_base.php',
    'ezcImageGeometryFilters'                      => 'ImageConversion/interfaces/geometry.php',
    'ezcImageImagemagickBaseHandler'               => 'ImageConversion/handlers/imagemagick_base.php',
    'ezcImageThumbnailFilters'                     => 'ImageConversion/interfaces/thumbnail.php',
    'ezcImageWatermarkFilters'                     => 'ImageConversion/interfaces/watermark.php',
    'ezcImageConverter'                            => 'ImageConversion/converter.php',
    'ezcImageConverterSettings'                    => 'ImageConversion/structs/converter_settings.php',
    'ezcImageFilter'                               => 'ImageConversion/structs/filter.php',
    'ezcImageGdHandler'                            => 'ImageConversion/handlers/gd.php',
    'ezcImageHandlerSettings'                      => 'ImageConversion/structs/handler_settings.php',
    'ezcImageImagemagickHandler'                   => 'ImageConversion/handlers/imagemagick.php',
    'ezcImageSaveOptions'                          => 'ImageConversion/options/save_options.php',
    'ezcImageTransformation'                       => 'ImageConversion/transformation.php',
);
?>
