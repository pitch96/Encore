//
//  UpdateEventModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 08/02/23.
//

import Foundation

// MARK: - update Event Model
struct GetEventModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: GetEventDetails?
}

// MARK: - GetEventDetails
struct GetEventDetails: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime: String?
    var image: String?
    var description: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt, eventCategoryName: String?
    var category: Categories?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case eventTitle = "event_title"
        case categoryID = "category_id"
        case organizer, venue, address, city, zipcode
        case startDate = "start_date"
        case endDate = "end_date"
        case startTime = "start_time"
        case endTime = "end_time"
        case image, description, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case eventCategoryName = "event_category_name"
        case category
    }
}

// MARK: - Get Category Model
struct Categories: Codable {
    var id, userID: Int?
    var name: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case name, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
// MARK: - Update Event Model
struct UpdateEventModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: UpdateEventDetail?
}

// MARK: - UpdateEventDetail
struct UpdateEventDetail: Codable {
    var id, userID: Int?
    var eventTitle, categoryID, organizer, venue: String?
    var address, city, zipcode, startDate: String?
    var endDate, startTime, endTime, image: String?
    var description: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case eventTitle = "event_title"
        case categoryID = "category_id"
        case organizer, venue, address, city, zipcode
        case startDate = "start_date"
        case endDate = "end_date"
        case startTime = "start_time"
        case endTime = "end_time"
        case image, description, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
