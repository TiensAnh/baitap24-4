# Student Manager Plugin

Plugin WordPress `Student Manager` duoc viet de quan ly sinh vien bang Custom Post Type, meta box va shortcode.

## Cau truc thu muc

```text
wp-content/
`-- plugins/
    `-- student-manager/
        |-- assets/
        |   `-- css/
        |       `-- student-manager.css
        |-- includes/
        |   |-- class-student-manager-meta-boxes.php
        |   |-- class-student-manager-post-type.php
        |   |-- class-student-manager-shortcode.php
        |   `-- class-student-manager.php
        `-- student-manager.php
```

## Chuc nang da hoan thanh

- Dang ky Custom Post Type `Sinh vien` trong menu WordPress.
- Ho tro 2 truong mac dinh: `title` (Ho ten sinh vien) va `editor` (Tieu su/Ghi chu).
- Them meta box gom `MSSV`, `Lop/Chuyen nganh`, `Ngay sinh`.
- Luu du lieu an toan bang `nonce`, `sanitize_text_field()`, whitelist dropdown va kiem tra dinh dang ngay.
- Tao shortcode `[danh_sach_sinh_vien]` hien thi danh sach sinh vien bang bang HTML.

## Cach su dung

1. Copy thu muc `student-manager` vao `wp-content/plugins/`.
2. Kich hoat plugin trong trang quan tri WordPress.
3. Tao du lieu trong menu `Sinh vien`.
4. Chen shortcode sau vao Page/Post:

```text
[danh_sach_sinh_vien]
```

## Minh hoa dau ra ky vong

| STT | MSSV | Ho ten | Lop | Ngay sinh |
| --- | ---- | ------ | --- | --------- |
| 1 | SV001 | Nguyen Van A | CNTT | 20/01/2003 |
| 2 | SV002 | Tran Thi B | Marketing | 15/08/2002 |

## Anh chup ket qua
<img width="1919" height="1079" alt="image" src="https://github.com/user-attachments/assets/1671a8cd-a3b0-47ca-8d3f-1373fca4418e" />



### Anh nen bo sung them

De README day du hon khi day len git, ban nen chup them 2 anh backend sau va luu trong `docs/images/`:

- `backend-menu-sinh-vien.png`: man hinh menu `Sinh vien` trong WordPress admin.
- `backend-form-sinh-vien.png`: man hinh form them/sua sinh vien co day du `MSSV`, `Lop/Chuyen nganh`, `Ngay sinh`.

## Git code

Workspace hien tai chua duoc ket noi voi mot repo remote, nen chua the tao link GitHub/GitLab thuc te tu day. Sau khi day code len git, hay cap nhat lai lien ket repo vao README neu bai nop yeu cau.




