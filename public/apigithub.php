<?php
require_once __DIR__ ."/public/config.php";

$query = <<<GQL
{
  viewer {
    login
    name
    url
    avatarUrl
    bio
    repositories(first: 6, orderBy: {field: UPDATED_AT, direction: DESC}) {
      totalCount
      nodes {
        name
        description
        url
        stargazerCount
        forkCount
        primaryLanguage {
          name
          color
        }
        updatedAt
      }
    }
    followers {
      totalCount
    }
    following {
      totalCount
    }
    contributionsCollection {
      contributionCalendar {
        totalContributions
        weeks {
          contributionDays {
            contributionCount
            date
            color
          }
        }
      }
    }
  }
}
GQL;

$payload = json_encode(['query' => $query]);

// Header dengan token dan user-agent
$headers = [
    "Authorization: Bearer". TOKEN_GITHUB,
    "Content-Type: application/json",
    "User-Agent: MyApp"
];

// Siapkan konteks HTTP
$options = [
    "http" => [
        "method"  => "POST",
        "header"  => implode("\r\n", $headers),
        "content" => $payload,
        "ignore_errors" => true 
    ]
];

$context = stream_context_create($options);

$api = file_get_contents('https://api.github.com/graphql', false, $context);

echo $api;
