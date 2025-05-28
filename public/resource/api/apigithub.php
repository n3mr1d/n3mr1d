<?php
// Token akses GitHub kamu (ganti dengan token kamu sendiri)
require_once __DIR__ ."/public/config.php";
// Query GraphQL
function inigit(){
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

// Inisialisasi cURL
$ch = curl_init('https://api.github.com/graphql');

// Set opsi cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . TOKEN_GITHUB,
    'Content-Type: application/json',
    'User-Agent: MyApp' // GitHub API memerlukan User-Agent
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $query]));

// Eksekusi permintaan
$response = curl_exec($ch);


// Tutup koneksi cURL
curl_close($ch);
header('Content-Type: application/json');
return $response;
}
inigit();