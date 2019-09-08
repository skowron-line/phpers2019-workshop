Mapping dla indexu offert

```json
PUT offers
{
  "mappings" : {
      "properties" : {
        "added_at" : {
          "type" : "date"
        },
        "company" : {
          "properties" : {
            "id" : {
              "type" : "text",
              "fields" : {
                "keyword" : {
                  "type" : "keyword",
                  "ignore_above" : 256
                }
              }
            },
            "is_paid_profile" : {
              "type" : "boolean"
            },
            "name" : {
              "type" : "text",
              "fields" : {
                "keyword" : {
                  "type" : "keyword",
                  "ignore_above" : 256
                }
              }
            }
          }
        },
        "expires_at" : {
          "type" : "date"
        },
        "localization" : {
          "properties" : {
            "city" : {
              "properties" : {
                "id" : {
                  "type" : "text",
                  "fields" : {
                    "keyword" : {
                      "type" : "keyword",
                      "ignore_above" : 256
                    }
                  }
                },
                "name" : {
                  "type" : "text",
                  "fields" : {
                    "keyword" : {
                      "type" : "keyword",
                      "ignore_above" : 256
                    }
                  }
                }
              }
            },
            "province" : {
              "properties" : {
                "id" : {
                  "type" : "long"
                },
                "name" : {
                  "type" : "text",
                  "fields" : {
                    "keyword" : {
                      "type" : "keyword",
                      "ignore_above" : 256
                    }
                  }
                }
              }
            }
          }
        },
        "salary" : {
          "properties" : {
            "from" : {
              "type" : "float"
            },
            "to" : {
              "type" : "float"
            },
            "value" : {
              "type" : "text",
              "fields" : {
                "keyword" : {
                  "type" : "keyword",
                  "ignore_above" : 256
                }
              }
            }
          }
        },
        "skills" : {
          "properties" : {
            "must" : {
              "type" : "text",
              "fields" : {
                "keyword" : {
                  "type" : "keyword",
                  "ignore_above" : 256
                }
              }
            },
            "nice_to_have" : {
              "type" : "text",
              "fields" : {
                "keyword" : {
                  "type" : "keyword",
                  "ignore_above" : 256
                }
              }
            }
          }
        },
        "title" : {
          "type" : "text",
          "fields" : {
            "keyword" : {
              "type" : "keyword",
              "ignore_above" : 256
            }
          }
        },
        "views_count" : {
          "type" : "long"
        }
      }
    }
}
```

Przykladowe dane

```json
PUT offers/_doc/1
{"title":"php developer","salary":{"from":"10000","to":"18000","value":"netto"},"added_at":"2019-01-12","expires_at":"2019-01-30","views_count":"12","skills":{"must":["php","mysql"],"nice_to_have":["casandra"]},"company":{"id":"1","name":"Company flow","is_paid_profile":false},"localization":[{"city":{"id":"1","name":"warsaw"},"province":{"id":1,"name":"mazowieckie"}},{"city":{"id":"2","name":"poznan"},"province":{"id":1,"name":"mazowieckie"}}]}

PUT offers/_doc/2
{"title":"frontend developer","salary":{"from":"10000","to":"23000","value":"netto"},"added_at":"2019-01-20","expires_at":"2019-02-10","views_count":"10","skills":{"must":["javascript","angular","css"],"nice_to_have":["react"]},"company":{"id":"2","name":"Big Will Company","is_paid_profile":true},"localization":[{"city":{"id":2,"name":"poznan"},"province":{"id":2,"name":"wielkopolskie"}}]}

PUT offers/_doc/3
{"title":"PHP ninja","salary":{"from":"10000","to":"17500","value":"brutto"},"added_at":"2019-01-14","expires_at":"2019-02-16","views_count":"1","skills":{"must":["php","mysql","redis"],"nice_to_have":["elasticsearch"]},"company":{"id":"2","name":"Big Will Company","is_paid_profile":true},"localization":[{"city":{"id":2,"name":"poznan"},"province":{"id":2,"name":"wielkopolskie"}}]}

PUT offers/_doc/4
{"title":"Frontend developer","salary":{"from":"5000","to":"9300","value":"brutto"},"added_at":"2019-01-14","expires_at":"2019-02-16","views_count":"1","skills":{"must":["javascript","angular","css"],"nice_to_have":["grunt","bower","npm"]},"company":{"id":"2","name":"Big Will Company","is_paid_profile":true},"localization":[{"city":{"id":2,"name":"poznan"},"province":{"id":2,"name":"wielkopolskie"}}]}
```

Wyszukanie frazy

```json
GET offers/_search
{
  "_source": "title",
  "query": {
    "multi_match": {
      "query": "php developer",
      "fields": ["title"]
    }
  }
}
```


Wyszukanie frazy strikt i pelnoteskstowo

```json
GET offers/_search
{
  "_source": "title",
  "query": {
    "bool": {
      "should": [
        {
          "multi_match": {
            "query": "php developer",
            "fields": ["title"],
            "operator": "and"
          }
        },
        {
          "multi_match": {
            "query": "php developer",
            "fields": ["title"],
            "operator": "or"
          }
        }
      ]
    }
  }
}
```

Ilosc ofert w miescie

```json
GET offers/_search
{
  "size": 0,
  "aggs": {
    "offers_in_city": {
      "terms": {
        "field": "localization.city.name.keyword",
        "size": 10
      }
    }
  }
}
```

Średnia pensja

```json
GET offers/_search
{
  "size": 0,
  "aggs": {
    "avg_salary": {
      "avg": {
        "script": {
          "lang": "painless",
          "source": "doc['salary.to'].value - doc['salary.from'].value"
        }
      }
    }
  }
}
```

Srednia zarobkow brutto / netto w firmie

```json
GET offers/_search
{
  "size": 0,
  "aggs": {
    "offers_in_city": {
      "terms": {
        "field": "company.name.keyword",
        "size": 10
      },
      "aggs": {
        "offer_salary_type": {
          "terms": {
            "field": "salary.value.keyword",
            "size": 10
          },
          "aggs": {
            "avg_salary": {
              "stats": {
                "script": {
                  "lang": "painless",
                  "source": "doc['salary.to'].value - doc['salary.from'].value"
                }
              }
            }
          }
        }
      }
    }
  }
}
```

Wiecej niz 2 wymagane skille

```json
GET offers/_search
{
  "query": {
    "script": {
      "script": {
        "lang": "painless",
        "source": "doc['skills.must.keyword'].length > 2"
      }
    }
  }
}
```

Podbijanie ofert ktore maja mniej niz 10 odwiedzin, a obiżanie ofert które są często odwiedzane

```json
GET offers/_search
{
  "_source": ["title", "views_count"],
  "query": {
    "function_score": {
      "score_mode": "sum",
      "boost_mode": "replace",
      "query": {
        "multi_match": {
          "query": "PHP Developer",
          "fields": ["title"],
          "boost": 0
        }
      },
      "functions": [
        {
          "filter": {
            "range": {
              "views_count": {
                "lt": 10
              }
            }
          },
          "weight": 10
        },
        {
          "filter": {
            "range": {
              "views_count": {
                "gte": 10
              }
            }
          },
          "weight": 1
        }
      ]
    }
  }
}
```

Srednia zarobkow netto i brutto w miastach

```json
GET offers/_search
{
  "size": 0,
  "aggs": {
    "offers_in_city": {
      "terms": {
        "field": "localization.city.name.keyword"
      },
      "aggs": {
        "avg_salary_by_type": {
          "terms": {
            "field": "salary.value.keyword"
          },
          "aggs": {
            "avg_salary_in_city": {
              "avg": {
                "script": {
                  "lang": "painless",
                  "source": "doc['salary.to'].value - doc['salary.from'].value"
                }
              }
            }
          }
        }
      }
    }
  }
}
```



Translate sql query na elastic query dsl

```json
POST _sql/translate
{
  "query": """
    select title from offers where title like '%php%'
  """
}



Wykorzystanie synonimów

```json
PUT offers
{
  "settings": {
    "analysis": {
      "filter": {
        "title_synonyms_array": {
          "type": "synonym",
          "synonyms": [
            "ninja, wymiatacz => senior"
          ]
        }
      },
      "analyzer": {
        "title_synonyms": {
          "tokenizer": "whitespace",
          "filter": [
            "title_synonyms_array",
            "lowercase"
            ]
        }
      }
    }
  },
  "mappings": {
    "properties": {
      "title": {
        "type": "text",
        "analyzer": "title_synonyms"
      }
    }
  }
}

POST offers/_doc
{
  "title": "Senior developer"
}

GET offers/_search
{
  "query": {
    "multi_match": {
      "query": "ninja",
      "fields": ["title"]
    }
  }
}
```

Analiza tekstu w trakcie indexacji

```json
PUT summit
{
  "settings": {
    "analysis": {
      "char_filter": {
        "strip_html": {
          "type": "html_strip"
        },
        "fix_date": {
          "type": "pattern_replace",
          "pattern": "2k(\\d+)",
          "replacement": "20$1"
        }
      },
      "analyzer": {
        "conference_analyzer": {
          "type": "custom",
          "tokenizer": "standard",
          "char_filter": [
              "strip_html",
              "fix_date"
          ],
          "filter": [
            "lowercase",
            "asciifolding"
          ]
        }
      }
    }
  },
  "mappings": {
    "properties": {
      "title": {
        "type": "text",
        "analyzer": "conference_analyzer"
      }
    }
  }
}

```json
GET summit/_analyze
{
  "analyzer": "conference_analyzer", 
  "text": ["<b>Phpers-Summit 2k19 poznań</b>"]
}
```

Output

```json
{
  "tokens" : [
    {
      "token" : "phpers",
      "start_offset" : 3,
      "end_offset" : 9,
      "type" : "<ALPHANUM>",
      "position" : 0
    },
    {
      "token" : "summit",
      "start_offset" : 10,
      "end_offset" : 16,
      "type" : "<ALPHANUM>",
      "position" : 1
    },
    {
      "token" : "2019",
      "start_offset" : 17,
      "end_offset" : 21,
      "type" : "<NUM>",
      "position" : 2
    },
    {
      "token" : "poznan",
      "start_offset" : 22,
      "end_offset" : 32,
      "type" : "<ALPHANUM>",
      "position" : 3
    }
  ]
}
```

Przykładowy config dla logstasha do importu ofert z bazy mysql do indexu od umieszczenia na kontenerze elk w katalogu `/etc/logstash/conf.d/offers.conf` a następnie nalezy zrestartować service logstasha `service logstash restart`

```json
input {
    jdbc {
        jdbc_driver_library => "/var/mysql-connector-java-8.0.17.jar"
        jdbc_driver_class => "com.mysql.jdbc.Driver"
        jdbc_connection_string => "jdbc:mysql://mariadb:3306/phpers"
        jdbc_user => "phpers"
        jdbc_password => "phpers"
        jdbc_validate_connection => true
        statement => "SELECT * FROM offers WHERE added_at > :sql_last_value"
        use_column_value => true
        tracking_column => "added_at"
        tracking_column_type => "timestamp"
        schedule => "*/5 * * * * *"
    }
}
output {
    elasticsearch {
        index => "offers"
        hosts => ["http://localhost:9200"]
        document_id => "%{id}"
    }
    stdout {
        codec => rubydebug
    }
}
```