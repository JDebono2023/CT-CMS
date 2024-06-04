> # Canadian Tire Media Manager

Content management system holding sample media content for ads relevant to Canadian Tire. Media content is managed by ELM Admin users, and stored in AWS S3. Content is accessed by Client and Sales staff users. Primary purpose is to provide a single location for each store to view media content and email in media requests directly to ELM staff.


> ## Project Details
- dev: J.Debono
- initialized: July 18, 2023
- launch date: 2024
- elm bucket: elm-clientapps/canadiantirecms *see filesystems.php for custom driver details
- repo: CTMediaManager
    - 2 branches: 
        - main: original deployment
        - rewrite_02-2024: core revisions to change media data (video and images) to be stored in a single table. This is the current version used.
        - rewrite:
            - files no longer being used:
                - Controllers-Livewire: Videos.php, Images.php, SelectedImageContent, SelectedVideoCOntent, SelectedImageCOntentOrig
                - Models: categoryImage.php, categoryVideo.php, imageContent.php, videoContent.php
                - Policies: ImageContentPolicy.php, VideoContentPolicy.php
                - Migrations: image_contents, video_contents, categoryimage, categoryvideo
                - Views: 
                    - client: CategoryImage, CategoryVideo
                    - contentImages
                    - contentVideos
                    - livewire: images, videos, selected-video-content, selected-image-content

- dependancies not used: 
    - realrashid/sweet-alert
    - intervention/image
    - php-ffmpeg/php-ffmpeg
- Adding Clients
    - ELM Admin creates a new store team
    - new user is invited to that team
- responsive view: minimum for viewing: 414px (within xxs-xs media break)


> ## Database Details

| Primary Table      | Secondary Table        | Relationship                |
| :--------------------------- | :--------------------------- | :---------------------------  |
| media              | categorymedia          | M:M media_id, category_id   |
|                    | types                  | 1:M type_id                 |
| categories         | categorymedia          | M:M media_id, category_id   |
| categorymedia      |                        |                             |
| types              | media                  | 1:M type_id                 |
| media_requests     |                        |                             |
| devices            |   not used             |                             |


> ## Teams & Authentication Details
- roles: 
    - ELM master Admin: elm (Administrator)
    - Client: store (Store Team)
    - Sales: store (Sales Team)
- adding users to teams is done by invite to team only. Individuals can not self register
- individual user teams are disabled
- users are managed via app/HTTP/Livewire/AllUsers.php 

> ## Permissions - See App/Policies 
- ELM granted full privileges
- Client & Sales: read only, access to Client interface only
- Sales: full request email functionality disabled for demo purposes


> ## Other Details.
- CSS via tailwindCSS
    - see tailwind.config.js for customized CSS information

- Emails
    -team invite remains as standard
    - media-request-client: email confirmation for client media_requests
    - media-request: media request email sent to ELM staff




