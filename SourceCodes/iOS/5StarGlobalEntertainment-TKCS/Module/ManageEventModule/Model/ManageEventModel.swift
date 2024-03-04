//
//  ManageEventModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 07/02/23.
//

import Foundation
// MARK: - Delete model
struct DeleteEventModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
}

// MARK: - Get All Event Model
struct ManageEventModel: Codable {
var statusCode: Int?
var success: Bool?
var message: String?
var data: [ManageEventModelDetail]?
}

// MARK: - Details
struct ManageEventModelDetail: Codable {
var id, userID: Int?
var eventTitle: String?
var categoryID: Int?
var organizer, venue, address, city: String?
var zipcode, startDate, endDate, startTime: String?
var endTime: String?
var image: String?
var description: String?
var status: Int,verifiedPromoterEvent, isPopular: Int??
var deletedAt: String?
var createdAt, updatedAt: String?
var paybleAmount: Int?
var eventStatus: String?
var promoterRequestResponse: PromoterRequestResponse1?

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
    case image, description, status,verifiedPromoterEvent, isPopular
    case deletedAt = "deleted_at"
    case createdAt = "created_at"
    case updatedAt = "updated_at"
    case paybleAmount
    case eventStatus = "event_status"
    case promoterRequestResponse = "promoter_request_response"
}
}
// MARK: - PromoterRequestResponse
struct PromoterRequestResponse1: Codable {
    var eventID, status: Int?
    enum CodingKeys: String, CodingKey {
        case eventID = "event_id"
        case status
    }
}
// MARK: - ALL Event Model

struct GetAllModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [GetAllData]?
}

// MARK: - Datum
struct GetAllData: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime, image, description: String?
    var status: Int,verifiedPromoterEvent, isPopular: Int?
    var deletedAt: String?
    var createdAt, updatedAt, eventStatus: String?
    var paybleAmount: Int?
    var promoterRequestResponse: PromoterRequestResponse?

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
        case image, description, status,verifiedPromoterEvent, isPopular
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case paybleAmount
        case eventStatus = "event_status"
        case promoterRequestResponse = "promoter_request_response"
    }
}

// MARK: - PromoterRequestResponse
struct PromoterRequestResponse: Codable {
    var eventID, status: Int?

    enum CodingKeys: String, CodingKey {
        case eventID = "event_id"
        case status
    }
}
// MARK: - Popular event Status
struct PopularEventStatusModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    //var data: [String]?
}
