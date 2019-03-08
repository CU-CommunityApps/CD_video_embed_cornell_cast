<?php

use Drupal\Core\Render\BubbleableMetadata;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Drupal\Core\Url;

/**
 * Implements hook_token_info().
 */
function video_embed_cornell_cast_token_info() {
  $types['video'] = [
    'name'        => t('Cornell video token'),
    'description' => t('Custom tokens to insert videos for Cornell sites.'),
  ];

  // Video token.
  $token['ID'] = [
    'name'        => t('Video ID'),
    'description' => t('Video ID will be a parameter.'),
  ];

  return [
    'types'   => $types,
    'tokens'  => [
      'video' => $token,
    ],
  ];
}

/**
 * Implements hook_tokens().
 */
function video_embed_cornell_cast_tokens($type, $tokens, array $data, array $options, BubbleableMetadata $bubbleable_metadata) {
  $token_service = \Drupal::token();
  $request = \Drupal::request();
  $route = $request->attributes->get(RouteObjectInterface::ROUTE_OBJECT);
  $replacements = [];
  if ($type == 'video') {
    foreach ($tokens as $video_id => $original) {
      $bubbleable_metadata->addCacheableDependency($video_id);
      $video_url  = '//www.cornell.edu/video/' . $video_id . '/embed/start0/end0';
      $video_code = "<iframe src='$video_url' width='640' height='360' frameborder='0' allowfullscreen></iframe>";
      $replacements[$original] = check_markup($video_code, 'full_html');
    }
  }
  return $replacements;
}
