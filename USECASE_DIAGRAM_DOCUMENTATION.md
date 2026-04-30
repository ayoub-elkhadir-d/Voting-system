# SystemVote - Use Case Diagram Documentation

## Overview
This document describes the professional Use Case Diagram for the **SystemVote** voting platform. The diagram models all actors, use cases, and their relationships in a single comprehensive view.

---

## System Actors

### 1. **Guest**
- **Description**: Unauthenticated user accessing the platform
- **Capabilities**:
  - Register a new account
  - Login to the system
- **Transitions**: Becomes a "Registered User" after successful login

### 2. **Registered User**
- **Description**: Authenticated user with full platform access
- **Capabilities**:
  - Create and manage voting rooms
  - Create and manage topics within rooms
  - Join existing rooms as a participant
  - View their own rooms
  - Request password reset
- **Transitions**: Can act as "Room Owner" when creating a room, or as "Participant" when joining a room

### 3. **Room Owner**
- **Description**: Registered user who created and owns a voting room
- **Capabilities**:
  - Full room management (edit, delete)
  - Topic lifecycle management (create, edit, delete, start, stop)
  - Member management (approve, remove)
  - Access admin panel with statistics
  - Start/broadcast room to participants
  - View vote statistics and timelines
- **Transitions**: Inherits all "Registered User" capabilities

### 4. **Participant**
- **Description**: Registered user who joined a room to participate in voting
- **Capabilities**:
  - Join rooms using room code
  - Enter a username for the session
  - Wait for approval (in private rooms)
  - Cast votes on active topics
  - View live voting results
  - Leave the room at any time
- **Transitions**: Becomes "Participant" after joining a room and being approved

---

## Use Cases by Category

### **Authentication & Account Management**

| Use Case | Actor | Description |
|----------|-------|-------------|
| **Register Account** | Guest | Create a new user account with email and password |
| **Login** | Guest, Registered User | Authenticate using email/password or magic link |
| **Request Password Reset** | Registered User | Initiate password recovery via email link |

### **Room Management**

| Use Case | Actor | Description |
|----------|-------|-------------|
| **Create Room** | Registered User | Create a new voting room with settings (public/private, member limit) |
| **View My Rooms** | Registered User | List all rooms owned by the user |
| **Edit Room** | Room Owner | Modify room settings (name, description, visibility, member limit) |
| **Delete Room** | Room Owner | Permanently remove a room and all associated data |
| **Start Room** | Room Owner | Activate room and broadcast to participants |

### **Topic Management**

| Use Case | Actor | Description |
|----------|-------|-------------|
| **Create Topic** | Room Owner | Add a new voting topic with choices and voting method |
| **Edit Topic** | Room Owner | Modify topic name, choices, duration, voting method |
| **Delete Topic** | Room Owner | Remove a topic from the room |
| **Start Topic** | Room Owner | Activate topic for voting (includes Start Room) |
| **Stop Topic** | Room Owner | End voting on current topic and show results |

### **Room Participation**

| Use Case | Actor | Description |
|----------|-------|-------------|
| **Join Room** | Registered User | Enter a room using 6-digit code (includes Enter Username) |
| **Enter Username** | Participant | Set display name for the voting session |
| **Wait for Approval** | Participant | Hold in waiting state until room owner approves (private rooms only) |
| **Leave Room** | Participant | Exit the room and stop participating |

### **Voting System**

| Use Case | Actor | Description |
|----------|-------|-------------|
| **Cast Vote** | Participant | Submit vote(s) on active topic (includes View Live Results) |
| **View Live Results** | Participant | See real-time vote counts and statistics |
| **View Vote Statistics** | Room Owner | Access detailed voting analytics and timelines |

### **Admin Functions**

| Use Case | Actor | Description |
|----------|-------|-------------|
| **View Admin Panel** | Room Owner | Access room dashboard with member list and statistics |
| **Approve Member** | Room Owner | Accept pending participant (private rooms) |
| **Remove Member** | Room Owner | Kick out a participant from the room |

---

## Relationships & Dependencies

### **Include Relationships** (Mandatory)
These represent functionality that is always executed as part of another use case:

1. **Join Room** `<<include>>` **Enter Username**
   - Joining a room always requires entering a username

2. **Cast Vote** `<<include>>` **View Live Results**
   - Voting automatically displays updated results

3. **Start Topic** `<<include>>` **Start Room**
   - Starting a topic requires the room to be active

### **Extend Relationships** (Conditional)
These represent optional behavior triggered under specific conditions:

1. **Enter Username** `<<extend>>` **Wait for Approval**
   - Waiting for approval only occurs in private rooms
   - Public rooms auto-approve participants

---

## Key Design Decisions

### 1. **Actor Hierarchy**
- **Registered User** is the base actor with core capabilities
- **Room Owner** extends Registered User with administrative privileges
- **Participant** is a specialized role for room members
- **Guest** is a pre-authentication state

### 2. **Use Case Grouping**
- Organized by functional domain (Auth, Room, Topic, Participation, Voting, Admin)
- Logical flow from left to right: Authentication → Room Management → Participation → Voting

### 3. **Relationship Modeling**
- `<<include>>` used for mandatory, always-executed functionality
- `<<extend>>` used for conditional behavior (e.g., approval in private rooms)
- Associations show direct actor-to-use-case interactions

### 4. **System Boundary**
- Clear boundary encompasses all internal use cases
- External systems (email, WebSocket) are implicit but not modeled as actors
- Focus on user-facing functionality

---

## Assumptions

1. **Authentication**
   - Users can register with email/password or use magic link login
   - Password reset is email-based
   - Session management is handled by Laravel

2. **Room Visibility**
   - **Public rooms**: Auto-approve participants
   - **Private rooms**: Require owner approval before voting
   - Room code is 6-digit numeric format

3. **Voting Methods**
   - Single choice: User votes for one option
   - Multiple choice: User can vote for multiple options (up to max_choices)
   - Vote changes are not allowed (immutable votes)

4. **Real-time Updates**
   - WebSocket (Reverb) broadcasts vote updates to all participants
   - Live results update in real-time as votes are cast
   - Room owner sees admin panel with statistics

5. **Member Management**
   - Only room owner can approve/remove members
   - Participants can voluntarily leave
   - Removed members cannot rejoin without re-entering code

6. **Topic Lifecycle**
   - Only one topic can be active at a time
   - Topics progress: pending → active → completed
   - Completed topics show final statistics

---

## Use Case Complexity Levels

### **Simple** (No dependencies)
- Register Account
- Login
- Request Password Reset
- View My Rooms
- Leave Room

### **Medium** (1-2 dependencies)
- Create Room
- Create Topic
- Join Room
- Cast Vote
- Approve Member

### **Complex** (Multiple dependencies)
- Edit Room (requires room ownership validation)
- Start Topic (requires room to be active, broadcasts to participants)
- View Admin Panel (aggregates multiple data sources)

---

## Future Extensions

Potential use cases for future versions:

1. **Analytics & Reporting**
   - Export voting results
   - Generate PDF reports
   - Schedule recurring votes

2. **Collaboration**
   - Share room templates
   - Collaborative topic creation
   - Comments/discussion on topics

3. **Advanced Voting**
   - Weighted voting
   - Ranked choice voting
   - Anonymous voting mode

4. **Integration**
   - Calendar integration
   - Slack/Teams notifications
   - API for third-party apps

---

## Diagram Files

- **usecase-diagram-main.drawio**: Main comprehensive use case diagram (draw.io format)
- **usecase-diagram-main.xml**: XML source for the diagram

To view/edit:
1. Open [app.diagrams.net](https://app.diagrams.net)
2. File → Open from Device → Select the .drawio file
3. Or import the XML directly

---

## Validation Checklist

✅ All actors identified and described
✅ All use cases named with clear verbs
✅ Relationships properly modeled (include/extend)
✅ System boundary clearly defined
✅ No overlapping elements
✅ Logical grouping and layout
✅ Scalable and production-ready
✅ Consistent with source code analysis
✅ Assumptions documented
✅ Future extensions identified

---

**Document Version**: 1.0
**Last Updated**: 2025
**Project**: SystemVote - Real-time Voting Platform
**Author**: Senior Software Architect
