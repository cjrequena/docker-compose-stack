## Sign in to the Oracle Container Registry.

1. In a web browser, sign in to the Oracle Container Registry using an Oracle account at https://container-registry.oracle.com.

2. Select the profile name. Select the profile name, and in the profile menu that appears select **Auth Token**.

3. Generate the **Secret Key**. Select Generate Secret Key and note down the secret key. This is only displayed once, during the initial generation.

4. (Optional) Regenerate the Secret Key. If you lose or forget the secret key, generate a new one by selecting Delete Secret Key, then select Generate Secret Key again.

5. Navigate to `database -> express` and accept the license agreement.

## Docker Login

```bash
   docker login container-registry.oracle.com -u your-email@example.com
   # Enter the auth token when prompted for password
```

## Pull the Image

```bash
  docker pull --platform=linux/amd64  container-registry.oracle.com/database/express:latest
```

## Run Docker Compose

```bash
  docker-compose up -d
```

## Connection Details

| Item        | Value                 |
| ----------- | --------------------- |
| Host        | `localhost`           |
| Port        | `1521`                |
| SID/Service | `XEPDB1` or `XE`      |
| Username    | `SYSTEM`              |
| Password    | `MySecurePassword123` |

| Field            | Value                                                    |
| ---------------- | -------------------------------------------------------- |
| **Host**         | `localhost`                                              |
| **Port**         | `1521`                                                   |
| **Service Name** | `XEPDB1` (for 21c XE)                                    |
| **SID**          | `XE` (if you’re using SID-style connection)              |
| **Username**     | `SYSTEM`                                                 |
| **Password**     | `MySecurePassword123` (as per your `docker-compose.yml`) |

---

## SQL Developer (GUI)

1. Download and open [Oracle SQL Developer](https://www.oracle.com/tools/downloads/sqldev-downloads.html).
2. Create a new connection:

    * **Username**: `SYSTEM`
    * **Password**: `MySecurePassword123`
    * **Hostname**: `localhost`
    * **Port**: `1521`
    * **Service name**: `XEPDB1` (not SID)
3. Click **Test**, then **Connect**.

---

## SQL\*Plus (CLI)

If you have `sqlplus` installed:

```bash
  sqlplus SYSTEM/MySecurePassword123@//localhost:1521/XEPDB1
```

---

## JDBC (Java)

```java
  String url = "jdbc:oracle:thin:@localhost:1521/XEPDB1";
  Connection conn = DriverManager.getConnection(url, "SYSTEM", "MySecurePassword123");
```

Make sure the Oracle JDBC driver (`ojdbc8.jar` or similar) is in your classpath.

---

## Using Docker Exec (for troubleshooting inside the container)

```bash
  docker exec -it oracledb bash
  sqlplus system/MySecurePassword123@XEPDB1
```

---
