
# Confluent Kafka Stack with KRaft Mode, Schema Registry, Connect, Control Center, and kSQLDB

This is a Docker Compose setup for running a full Confluent Kafka stack in KRaft (KRaft mode for KIP-500) mode, along with Kafka Schema Registry, Kafka Connect, Confluent Control Center, and kSQLDB.

The following components are included in this setup:
- **Kafka Broker (KRaft mode)**
- **Kafka Controller (KRaft mode)**
- **Schema Registry**
- **Kafka Connect**
- **Control Center**
- **kSQLDB Server**

## Prerequisites

- Docker
- Docker Compose

Ensure that you have Docker and Docker Compose installed. If not, please install Docker from [here](https://www.docker.com/get-started) and Docker Compose from [here](https://docs.docker.com/compose/install/).

## Setup and Configuration

### Clone this Repository
If you haven't already, clone this repository to your local machine:

```bash
git clone <repository-url>
cd <repository-directory>
```

### Docker Compose Configuration
The `docker-compose.yml` file defines all the services, networks, and configurations for the Kafka stack.

1. **Kafka Broker**: The Kafka broker is set up in KRaft mode (without Zookeeper).
2. **Kafka Controller**: Manages metadata in KRaft mode and handles leader elections.
3. **Schema Registry**: Manages Avro schemas for Kafka topics.
4. **Kafka Connect**: Enables Kafka integration with external systems using connectors.
5. **Control Center**: Provides a UI for managing Kafka topics, connectors, consumer groups, and more.
6. **kSQLDB Server**: Provides SQL-like querying capabilities over Kafka streams.

### Ports Exposed

- **Broker**: `9092` for Kafka clients, `9101` for JMX
- **Controller**: `9093` for controller communication, `9102` for JMX
- **Schema Registry**: `8081` for schema management
- **Kafka Connect**: `8083` for Kafka Connect REST API
- **Control Center**: `9021` for the Confluent Control Center UI
- **kSQLDB Server**: `8088` for kSQL queries via REST API

## Starting the Stack

To start the entire Confluent stack, use Docker Compose:

```bash
docker-compose up -d
```

This command will pull the required Docker images (if not already available) and start all services in detached mode.

### Verify Services are Running

You can check the status of all services using:

```bash
docker-compose ps
```

You should see the following containers running:
- `broker`
- `controller`
- `schema-registry`
- `connect`
- `control-center`
- `ksqldb-server`

## Accessing the Services

1. **Kafka Broker**: Connect to the Kafka broker using the advertised listener `PLAINTEXT://localhost:9092`.
2. **Control Center**: Access the Control Center UI by navigating to `http://localhost:9021`.
3. **Kafka Connect**: Use the Kafka Connect REST API at `http://localhost:8083` to manage connectors.
4. **Schema Registry**: Access the Schema Registry at `http://localhost:8081` for managing Avro schemas.
5. **kSQLDB**: Query Kafka topics via the kSQLDB REST API at `http://localhost:8088`.

## Stopping the Stack

To stop and remove all containers, networks, and volumes, use:

```bash
docker-compose down
```

## Troubleshooting

### Logs
To view the logs of any container, use the following command:

```bash
docker-compose logs <service-name>
```

For example, to view Kafka Broker logs:

```bash
docker-compose logs broker
```

### Restarting Services
To restart any specific service (e.g., Kafka Broker):

```bash
docker-compose restart broker
```

## Customizing the Configuration

You can modify the `docker-compose.yml` file to change any settings, such as:
- Kafka cluster replication settings
- Schema Registry configuration
- Kafka Connect connectors and configurations
- Control Center environment settings

Make sure to update the `KSQL_BOOTSTRAP_SERVERS` and `CONTROL_CENTER_KSQL_KSQLDB1_URL` variables if you change any of the default configurations.

## Further Resources

- [Confluent Documentation](https://docs.confluent.io/)
- [Apache Kafka Documentation](https://kafka.apache.org/documentation/)
- [kSQLDB Documentation](https://docs.ksqldb.io/)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

### Key Sections:

- **Description**: Overview of the stack and its components.
- **Setup Instructions**: How to clone the repository, start the stack, and check status.
- **Service Access**: Details on how to connect to each service, like Control Center, Kafka Broker, and kSQLDB.
- **Logs and Troubleshooting**: How to troubleshoot and view logs for specific services.
- **Customization**: Guidance on how to modify the configuration.
- **Further Resources**: Links to Confluent, Kafka, and kSQLDB documentation.
