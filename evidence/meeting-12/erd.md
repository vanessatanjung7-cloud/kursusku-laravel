# ERD Final — KursusKu Pertemuan 12

```mermaid
erDiagram
    COURSES ||--o{ ENROLLMENTS : has
    PARTICIPANTS ||--o{ ENROLLMENTS : registers

    COURSES {
        bigint id PK
        string code UK
        string name
        text description
        bigint fee
        int quota
        date start_date
        string status
        timestamp created_at
        timestamp updated_at
    }

    PARTICIPANTS {
        bigint id PK
        string name "max 100"
        string email UK "max 120"
        string phone "nullable, max 20"
        timestamp created_at
        timestamp updated_at
    }

    ENROLLMENTS {
        bigint id PK
        bigint participant_id FK "cascade on delete"
        bigint course_id FK "cascade on delete"
        string status "default registered, max 20"
        timestamp created_at
        timestamp updated_at
    }
```

Constraint unik pada `enrollments`: gabungan (`participant_id`, `course_id`). Artinya seorang peserta hanya memiliki satu pendaftaran untuk course yang sama. Course dan Participant tetap bisa memiliki banyak enrollment.

ERD ini merepresentasikan migration aktual project; migration `courses` berasal dari pertemuan sebelumnya dan tidak diubah.
